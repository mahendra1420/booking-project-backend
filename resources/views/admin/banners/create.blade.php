@extends('layouts.admin')
@section('title', 'Create Banner')
@section('page-title', 'Create Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}" class="text-muted">Banners</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-border bg-white shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold" style="color:var(--admin-text);">
                    <i class="fa-solid fa-image text-primary me-2"></i>New Banner Details
                </h5>

                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold" style="color:var(--admin-text);">Banner Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Summer Sale Event">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label fw-semibold" style="color:var(--admin-text);">Banner Image <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Recommended size: 800x400px. Max size: 2MB.</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label fw-semibold" style="color:var(--admin-text);">Target Link (URL)</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link') }}" placeholder="https://example.com/promo">
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Where the user goes when they click the banner.</div>
                        @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold" style="color:var(--admin-text);">Display Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}">
                            <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Lower numbers appear first.</div>
                            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0 d-flex align-items-center pt-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="cursor:pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="is_active" style="cursor:pointer; color:var(--admin-text);">Active Banner</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4" style="border-color:var(--admin-border) !important;">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Upload Banner</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
