@extends('layouts.admin')

@section('title', 'Coupons')
@section('page-title', 'Coupons')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-ticket-alt fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div class="flex-grow-1">
        <h2 class="mb-1">Coupons</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage discount coupons and promotions.</p>
    </div>
    <div>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Coupon
        </a>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>Code</th>
                <th>Discount</th>
                <th>Type</th>
                <th>Valid Until</th>
                <th>Usage</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coupons ?? [] as $coupon)
            <tr>
                <td><strong>{{ $coupon->code ?? 'N/A' }}</strong></td>
                <td>{{ ($coupon->type ?? '') == 'percentage' ? ($coupon->discount ?? 0).'%' : '$'.number_format($coupon->discount ?? 0, 2) }}</td>
                <td>{{ ucfirst($coupon->type ?? 'N/A') }}</td>
                <td>{{ $coupon->valid_until ?? 'N/A' }}</td>
                <td>{{ $coupon->used_count ?? 0 }} / {{ $coupon->usage_limit ?? '&infin;' }}</td>
                <td>
                    <span class="badge bg-{{ ($coupon->is_active ?? true) ? 'success' : 'danger' }}">
                        {{ ($coupon->is_active ?? true) ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-sm btn-info" style="color:#fff;" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this coupon?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="fas fa-tags fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No coupons found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
