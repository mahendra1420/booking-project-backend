<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function __construct(protected User $model) {}

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return (bool) $this->model->where('id', $id)->update($data);
    }
}
