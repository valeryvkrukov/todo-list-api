<?php

namespace App\TodoList\Task\Domain\Entity;


use App\Shared\ValueObject\IntegerMinMaxValueObject;

class TaskPriority extends IntegerMinMaxValueObject
{
    protected int $minValue = 1;
    protected int $maxValue = 5;
}