<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(protected UserRepository $userRepository) {}

    /**
     * Register a new user and return access token.
     */
    public function register(array $data): array
    {
        $user = $this->userRepository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'phone'    => $data['phone'] ?? null,
            'role'     => $data['role'] ?? 'customer',
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }

    /**
     * Login user with email/password and return access token.
     *
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        if (! $user->status) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['Your account has been suspended. Please contact support.'],
            ]);
        }

        // Revoke old tokens (single device login)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ];
    }

    /**
     * Logout user by revoking current token.
     */
    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
