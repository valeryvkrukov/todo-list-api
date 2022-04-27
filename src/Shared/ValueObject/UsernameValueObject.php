<?php

namespace App\Shared\ValueObject;


abstract class UsernameValueObject
{
    protected $value;

    public function __construct(string $value)
    {
        //TODO validate
        
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}