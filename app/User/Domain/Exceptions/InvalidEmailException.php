<?php

namespace App\User\Domain\Exceptions;

use Exception;
use Throwable;

class InvalidEmailException extends Exception
{
    public function __construct(string $email, Throwable $previous = null)
    {
        parent::__construct("email " . $email, $previous);
    }

}
