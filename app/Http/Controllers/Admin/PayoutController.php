<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function index(Request $request)
    {
        $payouts = Payout::with('business')->paginate(20);

        return view('admin.payouts.index', compact('payouts'));
    }

    public function process(Request $request, Payout $payout)
    {
        $request->validate([
            'transaction_ref' => 'required|string|max:255',
            'payout_date'     => 'required|date',
        ]);

        $payout->update([
            'status'          => 'processed',
            'transaction_ref' => $request->input('transaction_ref'),
            'payout_date'     => $request->input('payout_date'),
            'processed_by'    => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Payout processed successfully.');
    }
}
