<?php

namespace App\Shared\ValueObject;


use Symfony\Component\Serializer\Annotation\Groups;

abstract class EnumValueObject
{
    protected array $allowedValues;

    #[Groups(['parent', 'children'])]
    protected string $value;

    public function __construct(string $value)
    {
        if ($this->allowedValues) {
            $this->validateForAllowedValues($value);
        }
        
        $this->value = $value;
    }

    /**
     * @throws \InvalidArgumentException
     */
    protected function validateForAllowedValues(string $value): void
    {
        if (!in_array($value, $this->allowedValues)) {
            throw new \InvalidArgumentException(sprintf("Value '%s' is not allowed for this type", $value));
        }
    }

    public function getValue(): string
    {
        return $this->value;
    }
}