<?php

namespace App\Domain\Entities\User;

use App\Domain\Entities\DomainEntity;
use App\Domain\Exceptions\User\InvalidUsernameException;

class UserName extends DomainEntity
{

    /**
     * @throws InvalidUsernameException
     */
    public function __construct(?string $name)
    {
        if (empty($name)) {
            throw new InvalidUsernameException('Username cannot be empty');
        }

        if (strlen($name) < 3) {
            throw new InvalidUsernameException('Name must be at least 3 characters long');
        } else {
            $this->value = $name;
        }
    }

}
