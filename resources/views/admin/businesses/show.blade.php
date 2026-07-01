@extends('layouts.admin')
@section('title', $business->name . ' - Business Profile')
@section('page-title', 'Business Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.businesses.index') }}" class="text-muted">Businesses</a></li>
    <li class="breadcrumb-item active">{{ $business->name }}</li>
@endsection

@section('content')
<div class="row g-4">
    <!-- Left Column: Business Profile -->
    <div class="col-12 col-xl-4">
        <div class="card card-border bg-white shadow-sm h-100">
            <div class="card-body text-center pt-5">
                <div class="avatar-initials mb-3 mx-auto shadow-sm" style="width:110px; height:110px; font-size:40px; background:linear-gradient(135deg, var(--admin-primary), #a29bfe); color:#fff; border-radius:18px;">
                    {{ strtoupper(substr($business->name, 0, 1)) }}
                </div>
                <h4 class="mb-1 fw-bold" style="color:var(--admin-text);">{{ $business->name }}</h4>
                <p class="mb-2" style="color:var(--admin-text-muted); font-size:14px;">
                    <i class="fa-solid fa-layer-group me-1"></i>{{ $business->category->name ?? 'Uncategorized' }}
                </p>

                <div class="mb-4">
                    <span class="status-badge status-{{ $business->status }}">
                        {{ ucfirst($business->status) }} Business
                    </span>
                    @if($business->is_featured)
                        <span class="status-badge status-active ms-1"><i class="fa-solid fa-star me-1 text-warning"></i>Featured</span>
                    @endif
                </div>

                <!-- Actions based on status -->
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    @if($business->status === 'pending')
                        <form action="{{ route('admin.businesses.approve', ['id' => $business->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill fw-semibold">
                                <i class="fa-solid fa-check-circle me-1"></i>Approve
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger btn-sm px-4 rounded-pill fw-semibold" onclick="document.getElementById('rejectForm').style.display='block'">
                            <i class="fa-solid fa-times-circle me-1"></i>Reject
                        </button>
                    @elseif($business->status === 'active')
                        <form action="{{ route('admin.businesses.suspend', ['id' => $business->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm px-4 rounded-pill fw-semibold text-dark">
                                <i class="fa-solid fa-pause-circle me-1"></i>Suspend
                            </button>
                        </form>
                    @elseif($business->status === 'suspended')
                        <form action="{{ route('admin.businesses.approve', ['id' => $business->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm px-4 rounded-pill fw-semibold">
                                <i class="fa-solid fa-play-circle me-1"></i>Reactivate
                            </button>
                        </form>
                    @endif

                    <form action="{{ route('admin.businesses.feature', ['id' => $business->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-primary btn-sm px-3 rounded-pill fw-semibold" title="Toggle Feature">
                            <i class="fa-solid fa-star"></i>
                        </button>
                    </form>
                </div>

                <div id="rejectForm" class="mt-3 p-3 bg-light rounded text-start" style="display:none; border:1px solid var(--admin-border);">
                    <form action="{{ route('admin.businesses.reject', ['id' => $business->id]) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label" style="font-size:12px; font-weight:600;">Reason for Rejection</label>
                            <input type="text" name="reason" class="form-control form-control-sm" required placeholder="e.g. Incomplete documents">
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('rejectForm').style.display='none'">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-danger">Confirm Reject</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-footer bg-transparent border-top p-4" style="border-color:var(--admin-border) !important;">
                <h6 class="fw-bold mb-3" style="color:var(--admin-text); font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">Contact Info</h6>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3 text-primary d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(108,92,231,0.1); border-radius:10px;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">Business Email</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $business->email }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3 text-success d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(0,184,148,0.1); border-radius:10px;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">Phone Number</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $business->phone ?? 'Not provided' }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3 text-info d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(9,132,227,0.1); border-radius:10px;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">Address</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $business->address ?? 'Not provided' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Additional Details -->
    <div class="col-12 col-xl-8">
        <div class="row g-3 mb-4">
            <!-- Owner Details Card -->
            <div class="col-12 col-md-6">
                <div class="card card-border bg-white shadow-sm h-100 p-4">
                    <h6 class="fw-bold mb-3" style="font-size:15px; color:var(--admin-text);"><i class="fa-solid fa-user-tie text-primary me-2"></i>Owner Information</h6>
                    @if($business->owner)
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-initials me-3" style="background:rgba(108,92,231,0.15); color:var(--admin-primary); width:48px; height:48px; font-size:18px;">
                            {{ strtoupper(substr($business->owner->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:15px; font-weight:700; color:var(--admin-text);">{{ $business->owner->name }}</div>
                            <div style="font-size:12px; color:var(--admin-text-muted);">Joined {{ $business->owner->created_at ? $business->owner->created_at->format('M Y') : 'Unknown' }}</div>
                        </div>
                    </div>
                    <div class="mb-1" style="font-size:13px;"><strong style="color:var(--admin-text);">Email:</strong> <span style="color:var(--admin-text-muted);">{{ $business->owner->email }}</span></div>
                    <div style="font-size:13px;"><strong style="color:var(--admin-text);">Phone:</strong> <span style="color:var(--admin-text-muted);">{{ $business->owner->phone ?? 'N/A' }}</span></div>
                    <div class="mt-3">
                        <a href="{{ route('admin.customers.show', $business->owner->id) }}" class="btn btn-sm btn-outline-primary" style="border-radius:6px; font-size:12px;">View Owner Profile</a>
                    </div>
                    @else
                    <div class="text-muted py-4 text-center">
                        <i class="fa-solid fa-user-slash fs-3 mb-2 opacity-50"></i>
                        <div>No owner assigned to this business.</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Commission & Settings Card -->
            <div class="col-12 col-md-6">
                <div class="card card-border bg-white shadow-sm h-100 p-4">
                    <h6 class="fw-bold mb-3" style="font-size:15px; color:var(--admin-text);"><i class="fa-solid fa-percent text-success me-2"></i>Financial Settings</h6>
                    
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color:var(--admin-border) !important;">
                        <span style="font-size:13px; font-weight:600; color:var(--admin-text);">Commission Rate</span>
                        <span class="badge bg-success" style="font-size:13px;">{{ $business->commission_rate ?? config('settings.default_commission', 10) }}%</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom" style="border-color:var(--admin-border) !important;">
                        <span style="font-size:13px; font-weight:600; color:var(--admin-text);">Total Revenue Generated</span>
                        <span style="font-size:14px; font-weight:700; color:var(--admin-primary);">$0.00</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span style="font-size:13px; font-weight:600; color:var(--admin-text);">Registration Date</span>
                        <span style="font-size:13px; color:var(--admin-text-muted);">{{ $business->created_at ? $business->created_at->format('d M Y, h:i A') : 'Unknown' }}</span>
                    </div>

                    @if($business->status === 'rejected')
                    <div class="mt-3 p-2 rounded" style="background:rgba(214,48,49,0.1); border:1px solid rgba(214,48,49,0.2);">
                        <div style="font-size:11px; font-weight:700; color:#D63031; text-transform:uppercase;">Rejection Reason</div>
                        <div style="font-size:13px; color:#D63031; margin-top:2px;">{{ $business->rejection_reason ?? 'No reason provided.' }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card card-border bg-white shadow-sm p-4">
            <h6 class="fw-bold mb-3" style="font-size:15px; color:var(--admin-text);"><i class="fa-solid fa-align-left text-primary me-2"></i>Business Description</h6>
            @if($business->description)
                <p style="font-size:14px; color:var(--admin-text-muted); line-height:1.6;">
                    {{ $business->description }}
                </p>
            @else
                <p style="font-size:14px; color:var(--admin-text-muted); font-style:italic;">No description provided by this business.</p>
            @endif
        </div>
    </div>
</div>
@endsection
