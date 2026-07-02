@extends('layouts.admin')
@section('title', 'Create Coupon')
@section('page-title', 'Create Coupon')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.coupons.index') }}" class="text-muted">Coupons</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-border bg-white shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold" style="color:var(--admin-text);">
                    <i class="fa-solid fa-ticket text-primary me-2"></i>New Coupon Details
                </h5>

                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="code" class="form-label fw-semibold" style="color:var(--admin-text);">Coupon Code <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control text-uppercase @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code') }}" required placeholder="e.g. SUMMER50">
                            <button class="btn btn-outline-primary fw-semibold" type="button" onclick="generateCode()">Generate</button>
                        </div>
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">The code customers will enter at checkout.</div>
                        @error('code') <div class="text-danger mt-1" style="font-size:13px;">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold" style="color:var(--admin-text);">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Flat Amount ($)</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="value" class="form-label fw-semibold" style="color:var(--admin-text);">Discount Value <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('value') is-invalid @enderror" id="value" name="value" value="{{ old('value') }}" required placeholder="e.g. 20">
                            @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="expires_at" class="form-label fw-semibold" style="color:var(--admin-text);">Expiration Date</label>
                            <input type="date" class="form-control @error('expires_at') is-invalid @enderror" id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                            <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Leave blank for no expiration.</div>
                            @error('expires_at') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <label for="max_uses" class="form-label fw-semibold" style="color:var(--admin-text);">Usage Limit</label>
                            <input type="number" class="form-control @error('max_uses') is-invalid @enderror" id="max_uses" name="max_uses" value="{{ old('max_uses') }}" placeholder="e.g. 100">
                            <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Max times this coupon can be used.</div>
                            @error('max_uses') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4" style="border-color:var(--admin-border) !important;">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Create Coupon</button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function generateCode() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 8; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('code').value = result;
    }
</script>
@endsection
