<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    /**
     * GET /api/services/{business}
     *
     * List all active services for a specific business.
     */
    public function index(int $businessId): JsonResponse
    {
        $business = Business::find($businessId);

        if (! $business || $business->status !== 'active') {
            return ApiResponse::notFound('Business not found.');
        }

        $services = Service::where('business_id', $businessId)
                           ->active()
                           ->orderBy('name')
                           ->get();

        return ApiResponse::success([
            'business' => [
                'id'   => $business->id,
                'name' => $business->name,
            ],
            'services' => $services,
        ], 'Services retrieved successfully.');
    }
}
