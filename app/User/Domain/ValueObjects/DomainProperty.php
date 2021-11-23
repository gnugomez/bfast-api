<?php

namespace App\User\Domain\ValueObjects;

/**
 * @property string $value
 */
class DomainProperty
{
    private $__value;

    public function __get($name)
    {
        return $this->__value;
    }
}
