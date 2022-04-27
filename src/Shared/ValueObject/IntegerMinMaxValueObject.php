<?php

namespace App\Shared\ValueObject;


abstract class IntegerMinMaxValueObject
{
    protected int $minValue;
    protected int $maxValue;
    protected int $value;

    public function __construct(int $value)
    {
        if (is_int($this->minValue) || is_int($this->maxValue)) {
            $this->validateValueConditions($value);
        }
        
        $this->value = $value;
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validateValueConditions(int $value): void
    {
        if (is_int($this->minValue) && ($value < $this->minValue)) {
            throw new \InvalidArgumentException(sprintf('Min value for this type is %d -- %d given', $this->minValue, $value));
        }

        if (is_int($this->maxValue) && ($value > $this->maxValue)) {
            throw new \InvalidArgumentException(sprintf('Max value for this type is %d -- %d given', $this->maxValue, $value));
        }
    }

    public function getValue(): int
    {
        return $this->value;
    }
}