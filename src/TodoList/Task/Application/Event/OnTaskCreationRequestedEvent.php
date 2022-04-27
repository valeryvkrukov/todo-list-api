<?php

namespace App\TodoList\Task\Application\Event;


use Symfony\Contracts\EventDispatcher\Event;

class OnTaskCreationRequestedEvent extends Event
{
    private string $title;
    private string $description;
    private int $priority;
    private string $status;

    public function __construct(
        string $title,
        string $description,
        int $priority,
        string $status
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->status = $status;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}