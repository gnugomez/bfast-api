<?php

namespace App\User\Domain\ValueObjects;

class UserId extends DomainProperty
{

    public function __construct(?int $id)
    {
        $this->value = $id;
    }

}
