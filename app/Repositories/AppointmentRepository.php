<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AppointmentRepository
{
    public function __construct(protected Appointment $model) {}

    public function forUser(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['business', 'staff', 'services', 'payment'])
                             ->forUser($userId);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('appointment_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('appointment_date', '<=', $filters['date_to']);
        }

        return $query->orderByDesc('appointment_date')->paginate($perPage);
    }

    public function forBusiness(int $businessId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with(['user', 'staff', 'services', 'payment'])
                             ->forBusiness($businessId);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date'])) {
            $query->where('appointment_date', $filters['date']);
        }

        return $query->orderBy('appointment_date')->orderBy('start_time')->paginate($perPage);
    }

    public function findById(int $id): ?Appointment
    {
        return $this->model->with(['user', 'business', 'staff', 'services', 'payment', 'review'])->find($id);
    }

    public function create(array $data): Appointment
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->where('id', $id)->delete();
    }

    public function hasConflict(int $businessId, ?int $staffId, string $date, string $startTime, string $endTime, ?int $excludeId = null): bool
    {
        $query = $this->model->where('business_id', $businessId)
            ->where('appointment_date', $date)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q2) use ($startTime, $endTime) {
                      $q2->where('start_time', '<=', $startTime)
                         ->where('end_time', '>=', $endTime);
                  });
            });

        if ($staffId) {
            $query->where('staff_id', $staffId);
        }

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
