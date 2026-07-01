@extends('layouts.admin')

@section('title', 'Payments')
@section('page-title', 'Payments')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-money-bill-wave fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Payments</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">View and manage customer payments and transactions.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Appointment ID</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments ?? [] as $payment)
            <tr>
                <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                <td>#{{ $payment->appointment_id ?? 'N/A' }}</td>
                <td>{{ $payment->customer_name ?? 'N/A' }}</td>
                <td>${{ number_format($payment->amount ?? 0, 2) }}</td>
                <td>{{ ucfirst($payment->payment_method ?? 'N/A') }}</td>
                <td>
                    <span class="badge bg-{{ ($payment->status ?? '') == 'success' ? 'success' : 'warning' }}">
                        {{ ucfirst($payment->status ?? 'Pending') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-receipt fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No payments found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
