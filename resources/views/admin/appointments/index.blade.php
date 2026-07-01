@extends('layouts.admin')

@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-calendar-alt fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Appointments</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage all customer appointments.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Service/Barber</th>
                <th>Date & Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments ?? [] as $appointment)
            <tr>
                <td>#{{ $appointment->id ?? 'N/A' }}</td>
                <td>{{ $appointment->customer_name ?? 'N/A' }}</td>
                <td>
                    {{ $appointment->service_name ?? 'N/A' }}<br>
                    <small style="color: var(--admin-text-muted)">{{ $appointment->barber_name ?? 'N/A' }}</small>
                </td>
                <td>{{ $appointment->appointment_date ?? 'N/A' }} {{ $appointment->appointment_time ?? '' }}</td>
                <td>
                    <span class="badge bg-{{ ($appointment->status ?? '') == 'completed' ? 'success' : 'primary' }}">
                        {{ ucfirst($appointment->status ?? 'Pending') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-calendar-times fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No appointments found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
