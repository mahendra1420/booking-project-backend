<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->withCount('appointments');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $customers = $query->latest()->paginate(20);

        $stats = [
            'total'     => User::where('role', 'customer')->count(),
            'active'    => User::where('role', 'customer')->where('status', true)->count(),
            'blocked'   => User::where('role', 'customer')->where('status', false)->count(),
            'new_today' => User::where('role', 'customer')->whereDate('created_at', today())->count(),
        ];

        return view('admin.customers.index', compact('customers', 'stats'));
    }

    public function show(User $customer)
    {
        $appointments = \App\Models\Appointment::with(['business', 'staff'])
            ->where('user_id', $customer->id)
            ->latest()
            ->paginate(10);
            
        $stats = [
            'total_bookings' => \App\Models\Appointment::where('user_id', $customer->id)->count(),
            'completed'      => \App\Models\Appointment::where('user_id', $customer->id)->where('status', 'completed')->count(),
            'cancelled'      => \App\Models\Appointment::where('user_id', $customer->id)->where('status', 'cancelled')->count(),
        ];

        // Pass it as 'user' to the view to avoid changing the blade variables
        $user = $customer;
        return view('admin.customers.show', compact('user', 'appointments', 'stats'));
    }

    public function destroy(User $customer)
    {
        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    public function toggleBlock(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = ! $user->status;
        $user->save();

        $status = $user->status ? 'unblocked' : 'blocked';

        return redirect()->back()->with('success', "Customer {$status} successfully.");
    }

    public function export(Request $request)
    {
        // TODO: implement CSV/Excel export
        $customers = User::all();

        return response()->json(['message' => 'Export placeholder', 'count' => $customers->count()]);
    }
}
