<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function __construct(protected ReviewService $reviewService) {}

    /**
     * GET /api/reviews/{business}
     *
     * Get approved reviews for a business.
     */
    public function index(int $businessId): JsonResponse
    {
        $reviews = $this->reviewService->getBusinessReviews($businessId);

        return ApiResponse::success($reviews, 'Reviews retrieved successfully.');
    }

    /**
     * POST /api/review
     *
     * Post a review for a completed appointment.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'appointment_id' => ['required', 'integer', 'exists:appointments,id'],
            'rating'         => ['required', 'integer', 'min:1', 'max:5'],
            'comment'        => ['nullable', 'string', 'max:1000'],
        ]);

        try {
            $review = $this->reviewService->postReview($request->user(), $validated);

            return ApiResponse::created($review, 'Review submitted successfully. It will be visible after approval.');
        } catch (ValidationException $e) {
            return ApiResponse::validationError($e->errors());
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to submit review. Please try again.');
        }
    }
}
