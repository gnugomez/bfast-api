<?php

namespace App\User\Application\UseCases;

use App\User\Application\Exceptions\ApplicationException;
use App\User\Domain\Interfaces\UserRepositoryInterface;

class DeleteUser
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws ApplicationException
     */
    public function __invoke(int $id): void
    {
        if (!$this->repository->find($id)) {
            throw new ApplicationException(['User not found']);
        }
        $this->repository->delete($id);
    }

}
