@extends('layouts.admin')
@section('title', 'Customers')
@section('page-title', 'Customer Management')
@section('breadcrumb') <li class="breadcrumb-item active">Customers</li> @endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="fa-solid fa-users me-2 text-primary"></i>Customers</h4>
        <p>Manage all registered customers</p>
    </div>
    <a href="{{ route('admin.customers.export') }}" class="btn btn-outline-primary">
        <i class="fa-solid fa-download me-2"></i>Export CSV
    </a>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Customers</div>
            <i class="fa-solid fa-users stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-success">{{ $stats['active'] }}</div>
            <div class="stat-label">Active</div>
            <i class="fa-solid fa-circle-check stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-danger">{{ $stats['blocked'] }}</div>
            <div class="stat-label">Blocked</div>
            <i class="fa-solid fa-ban stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-warning">{{ $stats['new_today'] }}</div>
            <div class="stat-label">New Today</div>
            <i class="fa-solid fa-user-plus stat-bg-icon"></i>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-card">
    <div class="table-header">
        <h6><i class="fa-solid fa-list me-2 text-primary"></i>All Customers</h6>
        <form class="d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name, email, phone..." value="{{ request('search') }}" style="width:240px;">
            <select name="status" class="form-select form-select-sm" style="width:130px;">
                <option value="">All Status</option>
                <option value="1" {{ request('status')=='1'?'selected':'' }}>Active</option>
                <option value="0" {{ request('status')=='0'?'selected':'' }}>Blocked</option>
            </select>
            <button class="btn btn-sm btn-primary px-3">Filter</button>
            @if(request()->anyFilled(['search','status']))
                <a href="{{ route('admin.customers.index') }}" class="btn btn-sm btn-secondary px-3">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Bookings</th>
                    <th>Joined</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td style="color:var(--admin-text-muted); font-size:13px;">{{ $customer->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-initials" style="background:rgba(108,92,231,0.15); color:#A29BFE;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:13px; font-weight:600; color:var(--admin-text);">{{ $customer->name }}</div>
                                <div style="font-size:11px; color:var(--admin-text-muted);">{{ $customer->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;">{{ $customer->phone ?? '—' }}</td>
                    <td>
                        <span style="font-size:13px; font-weight:600; color:#A29BFE;">{{ $customer->appointments_count ?? 0 }}</span>
                    </td>
                    <td style="font-size:12px; color:var(--admin-text-muted);">{{ $customer->created_at ? $customer->created_at->format('d M Y') : 'Unknown' }}</td>
                    <td>
                        <span class="status-badge {{ $customer->status ? 'status-active' : 'status-rejected' }}">
                            {{ $customer->status ? 'Active' : 'Blocked' }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm" style="background:rgba(9,132,227,0.15); color:#74B9FF; border:none; border-radius:8px; padding:5px 10px;">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.customers.toggle-block', ['id' => $customer->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background:{{ $customer->status ? 'rgba(214,48,49,0.15)' : 'rgba(0,184,148,0.15)' }}; color:{{ $customer->status ? '#FF7675' : '#00B894' }}; border:none; border-radius:8px; padding:5px 10px;"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fa-solid fa-{{ $customer->status ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(214,48,49,0.1); color:#FF7675; border:none; border-radius:8px; padding:5px 10px;"
                                    onclick="return confirm('Delete this customer permanently?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5" style="color:var(--admin-text-muted);">
                        <i class="fa-solid fa-users fa-2x mb-3 d-block opacity-30"></i>
                        No customers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="p-3 d-flex justify-content-between align-items-center" style="border-top:1px solid var(--admin-border);">
        <div style="font-size:13px; color:var(--admin-text-muted);">
            Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results
        </div>
        {{ $customers->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
