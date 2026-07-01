@extends('layouts.admin')

@section('title', 'Audit Logs')
@section('page-title', 'Audit Logs')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-history fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Audit Logs</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Track system activities and administrator actions.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Time</th>
                <th>User</th>
                <th>Action</th>
                <th>Resource</th>
                <th>IP Address</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @forelse($auditLogs ?? $logs ?? [] as $log)
            <tr>
                <td>{{ $log->created_at ?? 'N/A' }}</td>
                <td>{{ $log->user_name ?? 'System' }}</td>
                <td>
                    @php
                        $actionColor = match($log->action ?? '') {
                            'create' => 'success',
                            'update' => 'primary',
                            'delete' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $actionColor }}">{{ strtoupper($log->action ?? 'LOG') }}</span>
                </td>
                <td>{{ $log->resource ?? 'N/A' }}</td>
                <td><code>{{ $log->ip_address ?? 'N/A' }}</code></td>
                <td>
                    <button class="btn btn-sm btn-outline-info" title="View Payload"><i class="fas fa-code"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-clipboard-list fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No audit logs found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
