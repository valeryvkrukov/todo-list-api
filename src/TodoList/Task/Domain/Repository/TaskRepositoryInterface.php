<?php

namespace App\TodoList\Task\Domain\Repository;


use App\TodoList\Task\Domain\Entity\Task;

interface TaskRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();

    public function save(Task $task): void;
}