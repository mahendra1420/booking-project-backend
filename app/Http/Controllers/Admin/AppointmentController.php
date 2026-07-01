<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $appointments = Appointment::with(['user', 'business', 'staff'])->paginate(20);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'business', 'staff']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled,no_show',
        ]);

        $appointment->update(['status' => $request->input('status')]);

        return redirect()->back()->with('success', 'Appointment status updated.');
    }
}
