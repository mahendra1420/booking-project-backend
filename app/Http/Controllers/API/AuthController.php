<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    /**
     * POST /api/register
     *
     * Register a new user account.
     */
    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['nullable', 'in:customer,business_owner'],
        ]);

        try {
            $result = $this->authService->register($validated);

            return ApiResponse::created($result, 'Registration successful. Welcome!');
        } catch (\Exception $e) {
            return ApiResponse::error('Registration failed. Please try again.');
        }
    }

    /**
     * POST /api/login
     *
     * Authenticate user and return an access token.
     */
    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        try {
            $result = $this->authService->login([
                'email'    => $validated['email'],
                'password' => $validated['password'],
            ]);

            return ApiResponse::success($result, 'Login successful.');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), $e->errors(), 401);
        }
    }

    /**
     * POST /api/logout
     *
     * Revoke the current user's access token.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return ApiResponse::success(null, 'Logged out successfully.');
    }

    /**
     * GET /api/me
     *
     * Get the authenticated user's profile.
     */
    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(
            $request->user()->load('city'),
            'Profile retrieved successfully.'
        );
    }
}
