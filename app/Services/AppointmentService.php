<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use App\Repositories\AppointmentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class AppointmentService
{
    public function __construct(protected AppointmentRepository $appointmentRepository) {}

    /**
     * Get appointments for the authenticated user.
     */
    public function getUserAppointments(int $userId, array $filters = []): LengthAwarePaginator
    {
        return $this->appointmentRepository->forUser($userId, $filters);
    }

    /**
     * Book a new appointment.
     *
     * @throws ValidationException
     */
    public function book(User $user, array $data): Appointment
    {
        $business = Business::findOrFail($data['business_id']);
        $serviceIds = $data['service_ids'];

        // Load services and validate they belong to this business
        $services = Service::whereIn('id', $serviceIds)
            ->where('business_id', $business->id)
            ->where('status', true)
            ->get();

        if ($services->count() !== count($serviceIds)) {
            throw ValidationException::withMessages([
                'service_ids' => ['One or more services are invalid or inactive.'],
            ]);
        }

        // Calculate total duration and price
        $totalPrice    = $services->sum('price');
        $totalDuration = $services->sum('duration_minutes');

        // Calculate end time from start + duration
        $startTime = \Carbon\Carbon::createFromTimeString($data['start_time']);
        $endTime   = $startTime->copy()->addMinutes($totalDuration)->format('H:i:s');

        // Check for conflicting bookings
        if ($this->appointmentRepository->hasConflict(
            $business->id,
            $data['staff_id'] ?? null,
            $data['appointment_date'],
            $data['start_time'],
            $endTime
        )) {
            throw ValidationException::withMessages([
                'start_time' => ['This time slot is already booked. Please choose a different time.'],
            ]);
        }

        // Create appointment
        $appointment = $this->appointmentRepository->create([
            'user_id'          => $user->id,
            'business_id'      => $business->id,
            'staff_id'         => $data['staff_id'] ?? null,
            'appointment_date' => $data['appointment_date'],
            'start_time'       => $data['start_time'],
            'end_time'         => $endTime,
            'status'           => 'pending',
            'notes'            => $data['notes'] ?? null,
            'total_price'      => $totalPrice,
        ]);

        // Attach services with price snapshots
        $serviceData = $services->mapWithKeys(fn (Service $s) => [
            $s->id => ['price' => $s->price, 'duration_minutes' => $s->duration_minutes],
        ])->toArray();

        $appointment->services()->attach($serviceData);

        return $appointment->load(['business', 'staff', 'services']);
    }

    /**
     * Update appointment status.
     *
     * @throws ValidationException
     */
    public function update(int $appointmentId, User $user, array $data): Appointment
    {
        $appointment = $this->appointmentRepository->findById($appointmentId);

        if (! $appointment) {
            throw ValidationException::withMessages(['id' => ['Appointment not found.']]);
        }

        // Customers can only cancel their own appointments
        if ($user->isCustomer() && $appointment->user_id !== $user->id) {
            throw ValidationException::withMessages(['id' => ['You are not authorized to update this appointment.']]);
        }

        $allowedStatuses = $user->isCustomer() ? ['cancelled'] : ['confirmed', 'completed', 'cancelled', 'no_show'];

        if (! in_array($data['status'], $allowedStatuses)) {
            throw ValidationException::withMessages([
                'status' => ['You cannot set this status.'],
            ]);
        }

        $this->appointmentRepository->update($appointmentId, ['status' => $data['status']]);

        return $this->appointmentRepository->findById($appointmentId);
    }

    /**
     * Cancel (delete) an appointment.
     *
     * @throws ValidationException
     */
    public function cancel(int $appointmentId, User $user): void
    {
        $appointment = $this->appointmentRepository->findById($appointmentId);

        if (! $appointment) {
            throw ValidationException::withMessages(['id' => ['Appointment not found.']]);
        }

        if ($user->isCustomer() && $appointment->user_id !== $user->id) {
            throw ValidationException::withMessages(['id' => ['You are not authorized to cancel this appointment.']]);
        }

        if (in_array($appointment->status, ['completed', 'in_progress'])) {
            throw ValidationException::withMessages(['status' => ['Cannot cancel a completed or in-progress appointment.']]);
        }

        $this->appointmentRepository->update($appointmentId, ['status' => 'cancelled']);
    }
}
