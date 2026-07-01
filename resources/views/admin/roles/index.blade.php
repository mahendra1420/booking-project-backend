@extends('layouts.admin')

@section('title', 'Roles & Permissions')
@section('page-title', 'Roles & Permissions')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-user-shield fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div class="flex-grow-1">
        <h2 class="mb-1">Roles & Permissions</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage admin roles and their specific access permissions.</p>
    </div>
    <div>
        <button class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add Role</button>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Role Name</th>
                <th>Users Count</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($roles ?? [] as $role)
            <tr>
                <td>{{ $role->id ?? 'N/A' }}</td>
                <td><strong>{{ $role->name ?? 'N/A' }}</strong></td>
                <td>{{ $role->users_count ?? 0 }}</td>
                <td>{{ $role->created_at ?? 'N/A' }}</td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></button>
                    @if(($role->name ?? '') !== 'Super Admin')
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-shield-alt fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No roles found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
