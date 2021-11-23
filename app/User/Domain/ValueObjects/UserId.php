<?php

namespace App\User\Domain\ValueObjects;

class UserId
{
    private ?int $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }
}
