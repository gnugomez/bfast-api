<?php

namespace App\User\Application;

use App\Models\User;
use App\User\Domain\Contracts\UserRepositoryContract;

class FindByEmail
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $email)
    {
        return $this->repository->where('email', "=", $email)->first();
    }

}
