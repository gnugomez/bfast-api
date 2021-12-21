<?php

namespace App\Domain\Entities\User;

use App\Domain\Entities\DomainEntity;
use App\Domain\Exceptions\User\InvalidSurnameException;

class UserSurname extends DomainEntity
{

    /**
     * @throws InvalidSurnameException
     */
    public function __construct(?string $surname)
    {
        if (empty($surname)) {
            throw new InvalidSurnameException('Surname cannot be empty');
        }

        if (strlen($surname) < 3) {
            throw new InvalidSurnameException('Surname must be at least 3 characters long');
        } else {
            $this->value = $surname;
        }
    }

}
