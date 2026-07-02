@extends('layouts.admin')
@section('title', 'Edit Banner - ' . $banner->title)
@section('page-title', 'Edit Banner')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}" class="text-muted">Banners</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-border bg-white shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold" style="color:var(--admin-text);">
                    <i class="fa-solid fa-pen-to-square text-primary me-2"></i>Update Banner Details
                </h5>

                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold" style="color:var(--admin-text);">Banner Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--admin-text);">Current Image</label>
                        <div class="mb-2">
                            @if($banner->image_url)
                                <img src="{{ $banner->image_url }}" alt="Banner" style="max-height:150px; border-radius:8px; border:1px solid var(--admin-border);">
                            @else
                                <div class="text-muted" style="font-size:13px;">No image uploaded.</div>
                            @endif
                        </div>
                        
                        <label for="image" class="form-label fw-semibold" style="color:var(--admin-text);">Replace Image (Optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Leave blank to keep the current image. Max size: 2MB.</div>
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label fw-semibold" style="color:var(--admin-text);">Target Link (URL)</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $banner->link) }}" placeholder="https://example.com/promo">
                        @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="sort_order" class="form-label fw-semibold" style="color:var(--admin-text);">Display Order</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}">
                            @error('sort_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0 d-flex align-items-center pt-md-4">
                            <div class="form-check form-switch">
                                <!-- Hidden input ensures a value of 0 is sent if the checkbox is unchecked -->
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }} style="cursor:pointer;">
                                <label class="form-check-label ms-2 fw-semibold" for="is_active" style="cursor:pointer; color:var(--admin-text);">Active Banner</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 border-top pt-4" style="border-color:var(--admin-border) !important;">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Save Changes</button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
