<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function __construct(protected AppointmentService $appointmentService) {}

    /**
     * GET /api/appointments
     *
     * List the authenticated user's appointments.
     *
     * Query params: status, date_from, date_to, per_page
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'date_from', 'date_to']);
        $perPage = (int) $request->get('per_page', 10);

        $appointments = $this->appointmentService->getUserAppointments(
            $request->user()->id,
            $filters,
            $perPage
        );

        return ApiResponse::success($appointments, 'Appointments retrieved successfully.');
    }

    /**
     * POST /api/appointment
     *
     * Book a new appointment.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'business_id'      => ['required', 'integer', 'exists:businesses,id'],
            'service_ids'      => ['required', 'array', 'min:1'],
            'service_ids.*'    => ['integer', 'exists:services,id'],
            'staff_id'         => ['nullable', 'integer', 'exists:staff,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time'       => ['required', 'date_format:H:i'],
            'notes'            => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $appointment = $this->appointmentService->book($request->user(), $validated);

            return ApiResponse::created($appointment, 'Appointment booked successfully.');
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors(), $e->getMessage());
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to book appointment. Please try again.');
        }
    }

    /**
     * PUT /api/appointment/{id}
     *
     * Update appointment status.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,completed,cancelled,no_show'],
        ]);

        try {
            $appointment = $this->appointmentService->update($id, $request->user(), $validated);

            return ApiResponse::success($appointment, 'Appointment updated successfully.');
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        }
    }

    /**
     * DELETE /api/appointment/{id}
     *
     * Cancel an appointment.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        try {
            $this->appointmentService->cancel($id, $request->user());

            return ApiResponse::success(null, 'Appointment cancelled successfully.');
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        }
    }
}
