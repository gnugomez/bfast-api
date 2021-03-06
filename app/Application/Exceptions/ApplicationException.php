<?php

namespace App\Application\Exceptions;

class ApplicationException extends \Exception
{

    private array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
        parent::__construct();
    }

    public function addError(string $key, string $message)
    {
        $this->errors[$key][] = $message;
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

}
