<?php

namespace App\User\Domain\Objects;

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
