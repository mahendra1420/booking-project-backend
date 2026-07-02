@extends('layouts.admin')

@section('title', 'Banners')
@section('page-title', 'Banners')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-images fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div class="flex-grow-1">
        <h2 class="mb-1">Banners</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage app and website promotional banners.</p>
    </div>
    <div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Banner
        </a>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Position</th>
                <th>Link</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($banners ?? [] as $banner)
            <tr>
                <td>
                    @if(isset($banner->image_url))
                        <img src="{{ $banner->image_url }}" alt="Banner" width="80" class="rounded">
                    @else
                        <div class="bg-secondary text-center rounded p-2" style="width: 80px;"><i class="fas fa-image"></i></div>
                    @endif
                </td>
                <td>{{ $banner->title ?? 'N/A' }}</td>
                <td>{{ ucfirst($banner->position ?? 'App Home') }}</td>
                <td>{{ $banner->link ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ ($banner->is_active ?? true) ? 'success' : 'danger' }}">
                        {{ ($banner->is_active ?? true) ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.banners.show', $banner) }}" class="btn btn-sm btn-info" style="color:#fff;" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-photo-video fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No banners found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
