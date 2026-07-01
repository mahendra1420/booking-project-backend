<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\BusinessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function __construct(protected BusinessService $businessService) {}

    /**
     * GET /api/business
     *
     * List all active businesses with optional filters.
     *
     * Query params: category_id, city_id, search, sort (rating|reviews|newest), per_page
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['category_id', 'city_id', 'search', 'sort']);
        $perPage = (int) $request->get('per_page', 15);

        $businesses = $this->businessService->listBusinesses($filters, $perPage);

        return ApiResponse::success($businesses, 'Businesses retrieved successfully.');
    }

    /**
     * GET /api/business/{id}
     *
     * Get a single business with its services, staff, working hours, and images.
     */
    public function show(int $id): JsonResponse
    {
        $business = $this->businessService->getBusiness($id);

        if (! $business) {
            return ApiResponse::notFound('Business not found.');
        }

        return ApiResponse::success($business, 'Business retrieved successfully.');
    }
}
