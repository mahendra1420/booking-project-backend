<?php

namespace App\Repositories;

use App\Models\Business;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BusinessRepository
{
    public function __construct(protected Business $model) {}

    public function all(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['category', 'city', 'primaryImage'])
                             ->active();

        if (! empty($filters['category_id'])) {
            $query->byCategory($filters['category_id']);
        }

        if (! empty($filters['city_id'])) {
            $query->byCity($filters['city_id']);
        }

        if (! empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (! empty($filters['sort'])) {
            match ($filters['sort']) {
                'rating'   => $query->orderByDesc('average_rating'),
                'reviews'  => $query->orderByDesc('total_reviews'),
                'newest'   => $query->orderByDesc('created_at'),
                default    => $query->orderBy('name'),
            };
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Business
    {
        return $this->model->with([
            'category', 'city', 'images',
            'staff' => fn ($q) => $q->active(),
            'workingHours',
            'services' => fn ($q) => $q->active(),
        ])->find($id);
    }

    public function create(array $data): Business
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) $this->model->where('id', $id)->update($data);
    }

    public function existsForOwner(int $ownerId, string $slug): bool
    {
        return $this->model->where('owner_id', $ownerId)
                           ->where('slug', $slug)
                           ->exists();
    }
}
