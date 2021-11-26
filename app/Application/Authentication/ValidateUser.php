<?php

namespace App\Application\Authentication;

use App\Domain\Contracts\UserRepositoryContract;

class ValidateUser
{

    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }


    public function __invoke(){}

}
