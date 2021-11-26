<?php

namespace App\Api\Application\User;

use App\Infrastructure\Persistence\Eloquent\Models\User;
use App\Api\Domain\Contracts\UserRepositoryContract;

class FindByUserName
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(string $userName)
    {
        return $this->repository->where('username', "=", $userName)->first();
    }

}
