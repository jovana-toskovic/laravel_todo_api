<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{

    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function update(int $id, array $data): User
    {
        return $this->userRepository->update($id, $data);
    }

}
