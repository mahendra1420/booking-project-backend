<?php

namespace App\Repositories;

use App\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReviewRepository
{
    public function __construct(protected Review $model) {}

    public function forBusiness(int $businessId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->with('user')
                           ->where('business_id', $businessId)
                           ->approved()
                           ->orderByDesc('created_at')
                           ->paginate($perPage);
    }

    public function create(array $data): Review
    {
        return $this->model->create($data);
    }

    public function hasReviewedAppointment(int $userId, int $appointmentId): bool
    {
        return $this->model->where('user_id', $userId)
                           ->where('appointment_id', $appointmentId)
                           ->exists();
    }

    public function getAverageRating(int $businessId): array
    {
        $result = $this->model->where('business_id', $businessId)
                              ->approved()
                              ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total')
                              ->first();

        return [
            'average' => round((float) ($result->avg_rating ?? 0), 2),
            'total'   => (int) ($result->total ?? 0),
        ];
    }
}
