<?php

namespace App\TodoList\Task\Application\Command;


use App\TodoList\Task\Domain\Entity\Task;

class CreateTaskCommand
{
    private string $title;
    private string $description;
    private int $priority;
    private string $status;
    private string $user;
    private ?Task $parent;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): void
    {
        $this->priority = $priority;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    public function getParent(): ?Task
    {
        return $this->parent;
    }

    public function setParent(Task $parent): void
    {
        $this->parent = $parent;
    }
}