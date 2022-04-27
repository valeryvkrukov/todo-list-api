<?php

namespace App\TodoList\Task\Domain\Entity;


use App\Shared\ValueObject\EnumValueObject;

class TaskStatus extends EnumValueObject
{
    protected array $allowedValues = ['todo', 'done'];
}