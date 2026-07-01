@extends('layouts.admin')

@section('title', 'CMS Pages')
@section('page-title', 'CMS')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-file-alt fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div class="flex-grow-1">
        <h2 class="mb-1">CMS Pages</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage Terms & Conditions, Privacy Policy, and other static pages.</p>
    </div>
    <div>
        <button class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Page</button>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Last Updated</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cmsPages ?? $cms_pages ?? [] as $page)
            <tr>
                <td>{{ $page->title ?? 'N/A' }}</td>
                <td><code>{{ $page->slug ?? 'N/A' }}</code></td>
                <td>{{ $page->updated_at ?? 'N/A' }}</td>
                <td>
                    <span class="badge bg-{{ ($page->is_published ?? true) ? 'success' : 'secondary' }}">
                        {{ ($page->is_published ?? true) ? 'Published' : 'Draft' }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-file-signature fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No CMS pages found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
