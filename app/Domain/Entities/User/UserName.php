<?php

namespace App\Domain\Entities\User;

use App\Domain\Entities\DomainEntity;
use App\Domain\Exceptions\User\InvalidNameException;

class UserName extends DomainEntity
{

    /**
     * @throws InvalidNameException
     */
    public function __construct(?string $name)
    {
        if (empty($name)) {
            throw new InvalidNameException('Name cannot be empty');
        }

        if (strlen($name) < 3) {
            throw new InvalidNameException('Name must be at least 3 characters long');
        } else {
            $this->value = $name;
        }
    }

}
