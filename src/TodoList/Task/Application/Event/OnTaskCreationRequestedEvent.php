<?php

namespace App\TodoList\Task\Application\Event;


use Symfony\Contracts\EventDispatcher\Event;

class OnTaskCreationRequestedEvent extends Event
{
    private string $title;
    private string $description;
    private int $priority;
    private string $status;
    private string $user;

    public function __construct(
        string $title,
        string $description,
        int $priority,
        string $status,
        string $user
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->status = $status;
        $this->user = $user;
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

    public function getUser(): string
    {
        return $this->user;
    }
}