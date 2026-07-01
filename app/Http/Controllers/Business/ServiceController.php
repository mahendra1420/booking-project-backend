<?php

namespace App\Http\Controllers\Business;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * POST /api/service
     *
     * Create a new service for the authenticated business owner's business.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'business_id'      => ['required', 'integer', 'exists:businesses,id'],
            'name'             => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'price'            => ['required', 'numeric', 'min:0'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:480'],
        ]);

        // Ensure the authenticated user owns this business
        $business = Business::find($validated['business_id']);

        if (! $business || $business->owner_id !== $request->user()->id) {
            return ApiResponse::forbidden('You do not own this business.');
        }

        $service = Service::create($validated);

        return ApiResponse::created(
            $service->load('business'),
            'Service created successfully.'
        );
    }

    /**
     * PUT /api/service/{id}
     *
     * Update a service.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $service = Service::find($id);

        if (! $service) {
            return ApiResponse::notFound('Service not found.');
        }

        if ($service->business->owner_id !== $request->user()->id) {
            return ApiResponse::forbidden('You do not own this service.');
        }

        $validated = $request->validate([
            'name'             => ['sometimes', 'string', 'max:255'],
            'description'      => ['nullable', 'string', 'max:1000'],
            'price'            => ['sometimes', 'numeric', 'min:0'],
            'duration_minutes' => ['sometimes', 'integer', 'min:5', 'max:480'],
            'status'           => ['sometimes', 'boolean'],
        ]);

        $service->update($validated);

        return ApiResponse::success($service->fresh(), 'Service updated successfully.');
    }

    /**
     * DELETE /api/service/{id}
     *
     * Delete a service.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $service = Service::with('business')->find($id);

        if (! $service) {
            return ApiResponse::notFound('Service not found.');
        }

        if ($service->business->owner_id !== $request->user()->id) {
            return ApiResponse::forbidden('You do not own this service.');
        }

        $service->delete();

        return ApiResponse::success(null, 'Service deleted successfully.');
    }
}
