@extends('layouts.admin')
@section('title', 'Banner Details - ' . $banner->title)
@section('page-title', 'Banner Details')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.banners.index') }}" class="text-muted">Banners</a></li>
    <li class="breadcrumb-item active">Preview</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-10 col-xl-8">
        <div class="card card-border bg-white shadow-sm overflow-hidden">
            <!-- Banner Image Header -->
            <div class="bg-light d-flex align-items-center justify-content-center" style="min-height:200px; border-bottom:1px solid var(--admin-border);">
                @if($banner->image_url)
                    <img src="{{ $banner->image_url }}" alt="Banner" class="img-fluid w-100" style="object-fit:cover; max-height:400px;">
                @else
                    <div class="text-muted py-5 text-center">
                        <i class="fa-solid fa-image fa-3x mb-2 opacity-25"></i>
                        <p class="mb-0">No image available</p>
                    </div>
                @endif
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h3 class="fw-bold mb-1" style="color:var(--admin-text);">{{ $banner->title }}</h3>
                        <div style="font-size:14px; color:var(--admin-text-muted);">
                            Display Order: <strong>{{ $banner->sort_order ?? 0 }}</strong>
                        </div>
                    </div>
                    <div>
                        <span class="badge bg-{{ $banner->is_active ? 'success' : 'danger' }} px-3 py-2 rounded-pill" style="font-size:12px;">
                            {{ $banner->is_active ? 'Active Banner' : 'Inactive Banner' }}
                        </span>
                    </div>
                </div>

                <div class="mb-5">
                    <h6 class="fw-semibold mb-2" style="color:var(--admin-text); font-size:13px; text-transform:uppercase; letter-spacing:0.5px;">Target Link</h6>
                    @if($banner->link)
                        <a href="{{ $banner->link }}" target="_blank" class="d-inline-flex align-items-center p-3 rounded" style="background:rgba(108,92,231,0.05); color:var(--admin-primary); text-decoration:none; border:1px solid rgba(108,92,231,0.1); width:100%;">
                            <i class="fa-solid fa-link me-3 fs-5"></i>
                            <span class="text-truncate fw-medium">{{ $banner->link }}</span>
                            <i class="fa-solid fa-arrow-up-right-from-square ms-auto opacity-50"></i>
                        </a>
                    @else
                        <div class="text-muted p-3 rounded" style="background:var(--admin-surface); font-size:14px;">
                            <i class="fa-solid fa-unlink me-2"></i>No link attached to this banner.
                        </div>
                    @endif
                </div>

                <div class="d-flex gap-2 border-top pt-4" style="border-color:var(--admin-border) !important;">
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-primary px-4 fw-semibold"><i class="fa-solid fa-edit me-2"></i>Edit Banner</a>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
