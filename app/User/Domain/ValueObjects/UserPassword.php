<?php

namespace App\User\Domain\ValueObjects;

use App\User\Domain\Exceptions\InvalidPasswordException;

class UserPassword
{
    private string $password;

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
        $this->password = $password;
    }

    public function value(): string
    {
        return $this->password;
    }
}
