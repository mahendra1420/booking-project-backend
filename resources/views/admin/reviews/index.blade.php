@extends('layouts.admin')

@section('title', 'Reviews')
@section('page-title', 'Reviews')

@section('content')
<div class="admin-page-header d-flex align-items-center mb-4">
    <div class="header-icon me-3">
        <i class="fas fa-star fs-3" style="color: var(--admin-primary)"></i>
    </div>
    <div>
        <h2 class="mb-1">Reviews & Ratings</h2>
        <p class="mb-0" style="color: var(--admin-text-muted)">Manage customer feedback and ratings.</p>
    </div>
</div>

<div class="admin-table-card table-responsive bg-white rounded shadow-sm border  p-3">
    <table class="table table-hover  mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Service/Barber</th>
                <th>Rating</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews ?? [] as $review)
            <tr>
                <td>#{{ $review->id ?? 'N/A' }}</td>
                <td>{{ $review->customer_name ?? 'N/A' }}</td>
                <td>{{ $review->target_name ?? 'N/A' }}</td>
                <td>
                    <div class="text-warning">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= ($review->rating ?? 0))
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                </td>
                <td class="text-truncate" style="max-width: 200px;" title="{{ $review->comment ?? '' }}">
                    {{ $review->comment ?? 'No comment' }}
                </td>
                <td>{{ $review->created_at ?? 'N/A' }}</td>
                <td>
                    <button class="btn btn-sm btn-info " title="View"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-5" style="color: var(--admin-text-muted)">
                    <i class="far fa-star fs-1 mb-3 d-block"></i>
                    <p class="mb-0">No reviews found.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
