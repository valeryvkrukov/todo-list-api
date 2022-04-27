<?php

namespace App\TodoList\Task\Application\Query;


class FindAllTasksQuery
{
    private ?string $userId;
    private array $tasks;

    public function __construct(?string $userId = null)
    {
        $this->userId = $userId;
        $this->tasks = [];
    }

    public function getUserId(): ?string
    {
        return $this->userId;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }
}