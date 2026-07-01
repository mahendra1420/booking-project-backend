<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Review;
use App\Models\User;
use App\Repositories\ReviewRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ReviewService
{
    public function __construct(protected ReviewRepository $reviewRepository) {}

    /**
     * Get approved reviews for a business.
     */
    public function getBusinessReviews(int $businessId): LengthAwarePaginator
    {
        return $this->reviewRepository->forBusiness($businessId);
    }

    /**
     * Post a new review for a completed appointment.
     *
     * @throws ValidationException
     */
    public function postReview(User $user, array $data): Review
    {
        $appointment = Appointment::with('business')
            ->where('id', $data['appointment_id'])
            ->where('user_id', $user->id)
            ->first();

        if (! $appointment) {
            throw ValidationException::withMessages([
                'appointment_id' => ['Appointment not found or does not belong to you.'],
            ]);
        }

        if ($appointment->status !== 'completed') {
            throw ValidationException::withMessages([
                'appointment_id' => ['You can only review completed appointments.'],
            ]);
        }

        if ($this->reviewRepository->hasReviewedAppointment($user->id, $appointment->id)) {
            throw ValidationException::withMessages([
                'appointment_id' => ['You have already reviewed this appointment.'],
            ]);
        }

        $review = $this->reviewRepository->create([
            'user_id'        => $user->id,
            'business_id'    => $appointment->business_id,
            'appointment_id' => $appointment->id,
            'rating'         => $data['rating'],
            'comment'        => $data['comment'] ?? null,
            'is_approved'    => false, // Requires admin approval
        ]);

        // Update business average rating
        $stats = $this->reviewRepository->getAverageRating($appointment->business_id);
        $appointment->business->update([
            'average_rating' => $stats['average'],
            'total_reviews'  => $stats['total'],
        ]);

        return $review->load('user');
    }
}
