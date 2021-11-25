<?php

namespace App\Domain\Entities\User;

use App\Domain\Exceptions\User\InvalidPasswordException;

class UserPassword extends DomainEntity
{

    /**
     * @throws InvalidPasswordException
     */
    public function __construct(?string $password)
    {
        if (empty($password)) {
            throw new InvalidPasswordException('Password cannot be empty');
        }

        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/', $password)) {
            throw new InvalidPasswordException('Password must have at least 6 characters, 1 number, 1 special char and 1 uppercase letter');
        }
        $this->value = $password;
    }

}
