<?php

namespace App\TodoList\Task\Domain\Event;

use App\TodoList\Task\Domain\Entity\Task;
use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TaskChildAddedEvent extends Event implements DomainEventInterface
{
    protected Task $childTask;

    public function __construct(Task $childTask)
    {
        $this->childTask = $childTask;
    }

    public function getChildTask(): Task
    {
        return $this->childTask;
    }
}