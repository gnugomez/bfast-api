<?php

namespace App\Api\Domain\Exceptions\User;

use Exception;
use Throwable;

class InvalidPasswordException extends Exception
{
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
