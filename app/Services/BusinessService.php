<?php

namespace App\Services;

use App\Models\Business;
use App\Models\User;
use App\Repositories\BusinessRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class BusinessService
{
    public function __construct(protected BusinessRepository $businessRepository) {}

    /**
     * List all active businesses with optional filters.
     */
    public function listBusinesses(array $filters = []): LengthAwarePaginator
    {
        return $this->businessRepository->all($filters);
    }

    /**
     * Get a single business by ID with relationships.
     */
    public function getBusiness(int $id): ?Business
    {
        return $this->businessRepository->findById($id);
    }

    /**
     * Register a new business for the authenticated user.
     */
    public function registerBusiness(User $owner, array $data): Business
    {
        $slug = $this->generateUniqueSlug($data['name']);

        $business = $this->businessRepository->create([
            'owner_id'    => $owner->id,
            'category_id' => $data['category_id'],
            'city_id'     => $data['city_id'] ?? null,
            'name'        => $data['name'],
            'slug'        => $slug,
            'description' => $data['description'] ?? null,
            'address'     => $data['address'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'email'       => $data['email'] ?? null,
            'status'      => 'pending',
        ]);

        // Promote user role to business_owner
        if ($owner->role === 'customer') {
            $owner->update(['role' => 'business_owner']);
        }

        return $business->load(['category', 'city']);
    }

    /**
     * Register a new business without requiring an authenticated user.
     * owner_id is optional — pass it to link to an existing user.
     */
    public function registerBusinessPublic(array $data): Business
    {
        $slug = $this->generateUniqueSlug($data['name']);

        $business = $this->businessRepository->create([
            'owner_id'    => $data['owner_id'] ?? null,
            'category_id' => $data['category_id'],
            'city_id'     => $data['city_id'] ?? null,
            'name'        => $data['name'],
            'slug'        => $slug,
            'description' => $data['description'] ?? null,
            'address'     => $data['address'] ?? null,
            'latitude'    => $data['latitude'] ?? null,
            'longitude'   => $data['longitude'] ?? null,
            'phone'       => $data['phone'] ?? null,
            'email'       => $data['email'] ?? null,
            'status'      => 'pending',
        ]);

        // Promote user role to business_owner if owner_id was provided
        if (! empty($data['owner_id'])) {
            $owner = User::find($data['owner_id']);
            if ($owner && $owner->role === 'customer') {
                $owner->update(['role' => 'business_owner']);
            }
        }

        return $business->load(['category', 'city']);
    }

    private function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $count = 1;

        while (Business::where('slug', $slug)->exists()) {
            $slug = "{$original}-{$count}";
            $count++;
        }

        return $slug;
    }
}
