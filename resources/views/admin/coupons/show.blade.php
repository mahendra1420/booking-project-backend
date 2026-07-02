@extends('layouts.admin')
@section('title', 'Coupon Details - ' . $coupon->code)
@section('page-title', 'Coupon Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}" class="text-muted">Coupons</a></li>
    <li class="breadcrumb-item active">{{ $coupon->code }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-border bg-white shadow-sm">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <span class="badge bg-{{ $coupon->status ? 'success' : 'danger' }} px-3 py-2 rounded-pill" style="font-size:12px;">
                        {{ $coupon->status ? 'Active Coupon' : 'Inactive Coupon' }}
                    </span>
                </div>
                
                <h2 class="fw-bold mb-2 text-primary" style="letter-spacing:1px; font-size:32px;">{{ $coupon->code }}</h2>
                <div class="mb-4" style="color:var(--admin-text-muted); font-size:16px;">
                    Offers <strong>{{ $coupon->type == 'percentage' ? (float)$coupon->value . '%' : '$' . number_format($coupon->value, 2) }}</strong> discount
                </div>

                <div class="row g-3 text-start mt-4 pt-4 border-top" style="border-color:var(--admin-border) !important;">
                    <div class="col-6">
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; font-weight:600;">Total Uses</div>
                        <div style="font-size:18px; font-weight:700; color:var(--admin-text);">
                            {{ $coupon->used_count }} <span style="font-size:14px; color:var(--admin-text-muted); font-weight:400;">/ {{ $coupon->max_uses ?? 'Unlimited' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="font-size:11px; color:var(--admin-text-muted); text-transform:uppercase; font-weight:600;">Expiration Date</div>
                        <div style="font-size:16px; font-weight:600; color:var(--admin-text);">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : 'Never Expires' }}
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-5">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-primary px-4 fw-semibold"><i class="fa-solid fa-edit me-2"></i>Edit Coupon</a>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
