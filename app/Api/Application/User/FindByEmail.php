<?php

namespace App\Api\Application\User;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use App\Api\Domain\Contracts\UserRepositoryContract;

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
