@extends('layouts.admin')
@section('title', 'Businesses')
@section('page-title', 'Business Management')
@section('breadcrumb') <li class="breadcrumb-item active">Businesses</li> @endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="fa-solid fa-store me-2 text-primary"></i>Businesses</h4>
        <p>Manage service providers and approvals</p>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Businesses</div>
            <i class="fa-solid fa-store stat-bg-icon"></i>
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
            <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
            <div class="stat-label">Pending Approval</div>
            <i class="fa-solid fa-hourglass-half stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card">
            <div class="stat-value text-danger">{{ $stats['suspended'] }}</div>
            <div class="stat-label">Suspended</div>
            <i class="fa-solid fa-ban stat-bg-icon"></i>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="admin-table-card">
    <div class="table-header">
        <h6><i class="fa-solid fa-list me-2 text-primary"></i>All Businesses</h6>
        <form class="d-flex gap-2" method="GET">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search name, email, phone..." value="{{ request('search') }}" style="width:200px;">
            <select name="category_id" class="form-select form-select-sm" style="width:150px;">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <select name="status" class="form-select form-select-sm" style="width:130px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status')=='active'?'selected':'' }}>Active</option>
                <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>Suspended</option>
                <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
            </select>
            <button class="btn btn-sm btn-primary px-3">Filter</button>
            @if(request()->anyFilled(['search','status','category_id']))
                <a href="{{ route('admin.businesses.index') }}" class="btn btn-sm btn-secondary px-3">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless mb-0">
            <thead>
                <tr>
                    <th>Business</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($businesses as $business)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-initials" style="background:rgba(108,92,231,0.15); color:#A29BFE;">
                                {{ strtoupper(substr($business->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:13px; font-weight:600; color:#fff;">{{ $business->name }}</div>
                                <div style="font-size:11px; color:var(--admin-text-muted);">{{ $business->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:13px;">{{ $business->category?->name ?? '—' }}</td>
                    <td style="font-size:13px; color:var(--admin-text-muted);">
                        @if($business->city_id)
                            <i class="fa-solid fa-location-dot me-1"></i>City #{{ $business->city_id }}
                        @else
                            —
                        @endif
                    </td>
                    <td>
                        <span class="status-badge status-{{ $business->status }}">
                            {{ ucfirst($business->status) }}
                        </span>
                    </td>
                    <td>
                        @if($business->is_featured)
                            <span class="status-badge status-active"><i class="fa-solid fa-star me-1"></i>Featured</span>
                        @else
                            <span style="font-size:11px; color:var(--admin-text-muted);">No</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" style="border-radius:8px; font-size:12px; padding:4px 10px;">
                                Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.businesses.show', $business) }}"><i class="fa-solid fa-eye me-2 text-primary"></i>View Details</a></li>
                                <li><hr class="dropdown-divider divider"></li>
                                @if($business->status === 'pending')
                                <li>
                                    <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST">
                                        @csrf <button class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i>Approve</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.businesses.reject', $business->id) }}" method="POST">
                                        @csrf <button class="dropdown-item text-danger"><i class="fa-solid fa-xmark me-2"></i>Reject</button>
                                    </form>
                                </li>
                                @endif
                                
                                @if($business->status === 'active')
                                <li>
                                    <form action="{{ route('admin.businesses.suspend', $business->id) }}" method="POST">
                                        @csrf <button class="dropdown-item text-warning" onclick="return confirm('Suspend this business?')"><i class="fa-solid fa-ban me-2"></i>Suspend</button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.businesses.feature', $business->id) }}" method="POST">
                                        @csrf <button class="dropdown-item text-primary"><i class="fa-solid fa-star me-2"></i>{{ $business->is_featured ? 'Remove Featured' : 'Mark Featured' }}</button>
                                    </form>
                                </li>
                                @endif

                                @if($business->status === 'suspended' || $business->status === 'rejected')
                                <li>
                                    <form action="{{ route('admin.businesses.approve', $business->id) }}" method="POST">
                                        @csrf <button class="dropdown-item text-success"><i class="fa-solid fa-check me-2"></i>Re-Activate</button>
                                    </form>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:var(--admin-text-muted);">
                        <i class="fa-solid fa-store fa-2x mb-3 d-block opacity-30"></i>
                        No businesses found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($businesses->hasPages())
    <div class="p-3 d-flex justify-content-between align-items-center" style="border-top:1px solid var(--admin-border);">
        <div style="font-size:13px; color:var(--admin-text-muted);">
            Showing {{ $businesses->firstItem() }} to {{ $businesses->lastItem() }} of {{ $businesses->total() }} results
        </div>
        {{ $businesses->withQueryString()->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
