<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['user', 'appointment'])->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'appointment']);

        return view('admin.payments.show', compact('payment'));
    }

    public function refund(Request $request, Payment $payment)
    {
        // TODO: integrate with payment gateway refund API
        $payment->update(['status' => 'refunded']);

        return redirect()->back()->with('success', 'Refund initiated successfully.');
    }
}
