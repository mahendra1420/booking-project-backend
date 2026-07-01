<?php

namespace App\Http\Controllers\Business;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\BusinessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BusinessController extends Controller
{
    public function __construct(protected BusinessService $businessService) {}

    /**
     * POST /api/business/register
     *
     * Register a new business. No login required.
     * Pass owner_id to link the business to an existing user,
     * or leave it null to create as a guest/unlinked business.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'owner_id'    => ['nullable', 'integer', 'exists:users,id'],
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'city_id'     => ['nullable', 'integer', 'exists:cities,id'],
            'description' => ['nullable', 'string', 'max:2000'],
            'address'     => ['nullable', 'string', 'max:500'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:255'],
            'latitude'    => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'   => ['nullable', 'numeric', 'between:-180,180'],
        ]);

        try {
            $business = $this->businessService->registerBusinessPublic($validated);

            return ApiResponse::created(
                $business,
                'Business registered successfully. It will be active after admin approval.'
            );
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to register business. Please try again.');
        }
    }

    /**
     * GET /api/business/my
     *
     * Get all businesses owned by the authenticated user.
     */
    public function myBusinesses(Request $request): JsonResponse
    {
        $businesses = $request->user()
            ->businesses()
            ->with(['category', 'city'])
            ->paginate(10);

        return ApiResponse::success($businesses, 'Your businesses retrieved successfully.');
    }
}
