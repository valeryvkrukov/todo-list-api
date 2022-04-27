<?php

namespace App\TodoList\Task\Application\Query;


class FindUserTasksQuery
{
    private string $userId;
    private array $tasks;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
        $this->tasks = [];
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getTasks(): array
    {
        return $this->tasks;
    }
}