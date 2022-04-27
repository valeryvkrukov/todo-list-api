<?php

namespace App\TodoList\Task\Application\Query;

class FindTaskQuery
{
    private string $taskId;

    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }

    public function getTaskId(): string
    {
        return $this->taskId;
    }
}