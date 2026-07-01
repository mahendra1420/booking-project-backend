@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Service Categories')
@section('breadcrumb') <li class="breadcrumb-item active">Categories</li> @endsection

@section('content')
<div class="page-header d-flex align-items-center justify-content-between">
    <div>
        <h4><i class="fa-solid fa-layer-group me-2 text-primary"></i>Categories</h4>
        <p>Manage main categories and sub-categories</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus me-2"></i>Add Category
    </a>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Categories</div>
            <i class="fa-solid fa-tags stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-value text-primary">{{ $stats['parents'] }}</div>
            <div class="stat-label">Parent Categories</div>
            <i class="fa-solid fa-layer-group stat-bg-icon"></i>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card">
            <div class="stat-value text-info">{{ $stats['children'] }}</div>
            <div class="stat-label">Sub-Categories</div>
            <i class="fa-solid fa-diagram-project stat-bg-icon"></i>
        </div>
    </div>
</div>

{{-- Category List --}}
<div class="admin-table-card p-4">
    <h6 class="mb-4"><i class="fa-solid fa-sitemap me-2 text-primary"></i>Category Structure</h6>

    @if($categories->isEmpty())
        <div class="text-center py-5" style="color:var(--admin-text-muted);">
            <i class="fa-solid fa-layer-group fa-2x mb-3 d-block opacity-30"></i>
            No categories found. Click "Add Category" to create one.
        </div>
    @else
        <div class="category-tree">
            @foreach($categories as $category)
                {{-- Parent Category Item --}}
                <div class="category-item mb-3">
                    <div class="d-flex align-items-center justify-content-between p-3" style="background:var(--admin-surface); border:1px solid var(--admin-border); border-radius:12px;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-initials" style="background:rgba(108,92,231,0.15); color:#A29BFE; width:40px; height:40px; font-size:16px;">
                                @if($category->icon)
                                    <i class="fa-solid {{ $category->icon }}"></i>
                                @else
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-1" style="font-weight:700; color:#fff;">{{ $category->name }}</h6>
                                <span class="badge" style="background:rgba(108,92,231,0.1); color:#A29BFE;">
                                    {{ $category->children_count }} Sub-categories
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background:rgba(214,48,49,0.1); color:#FF7675; border:none; border-radius:8px;" onclick="return confirm('Delete this category? All sub-categories will also be deleted.')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Sub-categories --}}
                    @if($category->children->count() > 0)
                        <div class="ms-5 mt-2 ps-3 border-start" style="border-color:rgba(255,255,255,0.1) !important;">
                            @foreach($category->children as $child)
                                <div class="d-flex align-items-center justify-content-between p-2 mb-2" style="background:rgba(255,255,255,0.02); border-radius:8px; border:1px solid transparent;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initials" style="background:rgba(0,184,148,0.1); color:#00B894; width:28px; height:28px; font-size:12px;">
                                            {{ strtoupper(substr($child->name, 0, 1)) }}
                                        </div>
                                        <span style="font-size:14px; font-weight:500;">{{ $child->name }}</span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm" style="color:var(--admin-primary); padding:2px 6px;">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm text-danger" style="padding:2px 6px;" onclick="return confirm('Delete this sub-category?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
