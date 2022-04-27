<?php

namespace App\TodoList\Task\Domain\Event;

use App\TodoList\Task\Domain\Entity\TaskId;
use App\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TaskCreatedEvent extends Event implements DomainEventInterface
{
    protected TaskId $taskId;

    public function __construct(TaskId $taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): TaskId
    {
        return $this->taskId;
    }
}