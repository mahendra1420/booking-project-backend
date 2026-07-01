@extends('layouts.admin')
@section('title', $user->name . ' - Customer Details')
@section('page-title', 'Customer Profile')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}" class="text-muted">Customers</a></li>
    <li class="breadcrumb-item active">{{ $user->name }}</li>
@endsection

@section('content')
<div class="row g-4">
    <!-- Left Column: Profile Card -->
    <div class="col-12 col-xl-4">
        <div class="card card-border bg-white shadow-sm h-100">
            <div class="card-body text-center pt-5">
                <div class="avatar-initials mb-3 mx-auto" style="width:100px; height:100px; font-size:36px; background:rgba(108,92,231,0.1); color:var(--admin-primary);">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h4 class="mb-1 fw-bold" style="color:var(--admin-text);">{{ $user->name }}</h4>
                <p class="mb-3" style="color:var(--admin-text-muted); font-size:14px;">Customer since {{ $user->created_at ? $user->created_at->format('M Y') : 'Unknown' }}</p>
                
                <div class="mb-4">
                    <span class="status-badge {{ $user->status ? 'status-active' : 'status-rejected' }}">
                        {{ $user->status ? 'Active Account' : 'Blocked Account' }}
                    </span>
                </div>

                <div class="d-flex justify-content-center gap-2 mb-4">
                    <form action="{{ route('admin.customers.toggle-block', ['id' => $user->id]) }}" method="POST">
                        @csrf
                        <button class="btn btn-{{ $user->status ? 'danger' : 'success' }} btn-sm px-4 rounded-pill fw-semibold">
                            <i class="fa-solid fa-{{ $user->status ? 'ban' : 'check' }} me-2"></i>
                            {{ $user->status ? 'Block User' : 'Unblock User' }}
                        </button>
                    </form>
                    <button class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-semibold" onclick="alert('Message feature coming soon')">
                        <i class="fa-solid fa-envelope me-2"></i>Message
                    </button>
                </div>
            </div>
            <div class="card-footer bg-transparent border-top p-4" style="border-color:var(--admin-border) !important;">
                <h6 class="fw-bold mb-3" style="color:var(--admin-text); font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">Contact Info</h6>
                
                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3 text-primary d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(108,92,231,0.1); border-radius:10px;">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">Email Address</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3">
                    <div class="icon-box me-3 text-success d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(0,184,148,0.1); border-radius:10px;">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">Phone Number</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="icon-box me-3 text-info d-flex align-items-center justify-content-center" style="width:36px; height:36px; background:rgba(9,132,227,0.1); border-radius:10px;">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; letter-spacing:0.5px;">City ID</div>
                        <div style="font-size:14px; font-weight:600; color:var(--admin-text);">{{ $user->city_id ? 'City #' . $user->city_id : 'Not provided' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Stats & Appointments -->
    <div class="col-12 col-xl-8">
        <!-- Stats Row -->
        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="stat-card p-3 shadow-sm bg-white card-border h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-label mb-0" style="font-size:12px;">Total Bookings</div>
                        <i class="fa-solid fa-calendar-check text-primary" style="font-size:16px;"></i>
                    </div>
                    <div class="stat-value" style="font-size:24px;">{{ $stats['total_bookings'] }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card p-3 shadow-sm bg-white card-border h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-label mb-0" style="font-size:12px;">Completed</div>
                        <i class="fa-solid fa-circle-check text-success" style="font-size:16px;"></i>
                    </div>
                    <div class="stat-value" style="font-size:24px;">{{ $stats['completed'] }}</div>
                </div>
            </div>
            <div class="col-4">
                <div class="stat-card p-3 shadow-sm bg-white card-border h-100">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="stat-label mb-0" style="font-size:12px;">Cancelled</div>
                        <i class="fa-solid fa-circle-xmark text-danger" style="font-size:16px;"></i>
                    </div>
                    <div class="stat-value" style="font-size:24px;">{{ $stats['cancelled'] }}</div>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="admin-table-card shadow-sm bg-white">
            <div class="table-header p-4 pb-0 border-0">
                <h6 style="font-size:16px; font-weight:700;"><i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Booking History</h6>
            </div>
            
            <div class="table-responsive p-3">
                <table class="table table-hover table-borderless align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th style="border-radius:8px 0 0 8px;">Date</th>
                            <th>Business</th>
                            <th>Service/Staff</th>
                            <th>Status</th>
                            <th style="border-radius:0 8px 8px 0; text-align:right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appt)
                        <tr>
                            <td>
                                <div style="font-weight:600; font-size:13px; color:var(--admin-text);">{{ $appt->appointment_date ? \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') : 'Date TBD' }}</div>
                                <div style="font-size:11px; color:var(--admin-text-muted);">{{ $appt->appointment_time ? \Carbon\Carbon::parse($appt->appointment_time)->format('h:i A') : 'Time TBD' }}</div>
                            </td>
                            <td>
                                <div style="font-weight:600; font-size:13px; color:var(--admin-text);">{{ $appt->business->name ?? 'Unknown Business' }}</div>
                            </td>
                            <td>
                                <div style="font-size:13px; color:var(--admin-text);">Multiple Services</div>
                                <div style="font-size:11px; color:var(--admin-text-muted);">With {{ $appt->staff->name ?? 'Any Staff' }}</div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $appt->status }}">{{ ucfirst($appt->status) }}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.appointments.show', $appt->id) }}" class="btn btn-sm btn-light" style="border-radius:8px; font-size:12px;">
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted mb-2"><i class="fa-solid fa-calendar-xmark fa-2x opacity-50"></i></div>
                                <div style="font-size:14px; font-weight:500; color:var(--admin-text-muted);">No booking history found for this customer.</div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($appointments->hasPages())
                <div class="p-3 border-top">
                    {{ $appointments->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
