<?php

namespace TodoList\User\Domain\Repository;


use TodoList\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function find($id, $lockMode = null, $lockVersion = null);

    public function findAll();

    public function save(User $user): void;
}