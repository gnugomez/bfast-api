<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exceptions\InvalidUsernameException;

class UserName
{
    private string $name;

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
        }else{
            $this->name = $name;
        }
    }

    public function value(): string
    {
        return $this->name;
    }
}
