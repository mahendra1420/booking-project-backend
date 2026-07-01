@extends('layouts.admin')

@section('title', 'Payouts')
@section('page-title', 'Payouts')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-hand-holding-usd fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Payouts</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage and track payouts to barbers or vendors.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Payout ID</th>
                <th>Recipient</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payouts ?? [] as $payout)
            <tr>
                <td>#{{ $payout->id ?? 'N/A' }}</td>
                <td>{{ $payout->recipient_name ?? 'N/A' }}</td>
                <td>${{ number_format($payout->amount ?? 0, 2) }}</td>
                <td>{{ ucfirst($payout->payout_method ?? 'N/A') }}</td>
                <td>{{ $payout->created_at ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ ($payout->status ?? '') == 'completed' ? 'success' : 'warning' }}">
                        {{ ucfirst($payout->status ?? 'Pending') }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-primary" title="Process"><i class="fas fa-check-circle"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-file-invoice-dollar fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No payouts found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
