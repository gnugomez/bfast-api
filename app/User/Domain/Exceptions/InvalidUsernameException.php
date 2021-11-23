<?php

namespace App\User\Domain\Exceptions;

use Exception;
use Throwable;

class InvalidUsernameException extends Exception
{
    public function __construct(string $message, Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }

}
