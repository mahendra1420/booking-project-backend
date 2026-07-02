@extends('layouts.admin')
@section('title', 'Edit Category - ' . $category->name)
@section('page-title', 'Edit Category')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}" class="text-muted">Categories</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card card-border bg-white shadow-sm">
            <div class="card-body p-4">
                <h5 class="mb-4" style="color:var(--admin-text); font-weight:700;">
                    <i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Category Details
                </h5>

                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold" style="color:var(--admin-text);">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-semibold" style="color:var(--admin-text);">Slug URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required>
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">This will be used in the URL. Must be unique, lowercase, and no spaces.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="parent_id" class="form-label fw-semibold" style="color:var(--admin-text);">Parent Category</label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                            <option value="">-- None (Top Level Category) --</option>
                            @foreach($parentCategories as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text" style="color:var(--admin-text-muted); font-size:12px;">Select a parent if this is a sub-category.</div>
                        @error('parent_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">Save Changes</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4 fw-semibold">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-generate slug from name if user types in name field
    document.getElementById('name').addEventListener('input', function() {
        let slugField = document.getElementById('slug');
        // Only auto-fill if the user hasn't heavily modified the slug yet (simple check)
        if (!slugField.dataset.modified) {
            let slug = this.value.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            slugField.value = slug;
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.modified = true;
    });
</script>
@endsection
