@extends('layouts.admin')

@section('title', 'Support Tickets')
@section('page-title', 'Support')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-headset fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Support Tickets</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage and reply to customer and barber support inquiries.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>Subject</th>
                <th>User</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Last Updated</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supportTickets ?? $tickets ?? [] as $ticket)
            <tr>
                <td>#{{ $ticket->id ?? 'N/A' }}</td>
                <td>{{ $ticket->subject ?? 'N/A' }}</td>
                <td>{{ $ticket->user_name ?? 'N/A' }}</td>
                <td>
                    @php
                        $priorityColor = match($ticket->priority ?? 'low') {
                            'high' => 'danger',
                            'medium' => 'warning',
                            default => 'info'
                        };
                    @endphp
                    <span class="badge bg-{{ $priorityColor }}">{{ ucfirst($ticket->priority ?? 'Low') }}</span>
                </td>
                <td>
                    @php
                        $statusColor = match($ticket->status ?? 'open') {
                            'closed' => 'secondary',
                            'resolved' => 'success',
                            'in_progress' => 'primary',
                            default => 'danger'
                        };
                    @endphp
                    <span class="badge bg-{{ $statusColor }}">{{ ucfirst(str_replace('_', ' ', $ticket->status ?? 'Open')) }}</span>
                </td>
                <td>{{ $ticket->updated_at ?? 'N/A' }}</td>
                <td>
                    <button class="btn btn-sm btn-info " title="Reply"><i class="fas fa-reply"></i></button>
                    <button class="btn btn-sm btn-success" title="Resolve"><i class="fas fa-check"></i></button>
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-life-ring fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No support tickets found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
