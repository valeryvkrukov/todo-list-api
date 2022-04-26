<?php

namespace TodoList\User\Infrastructure\Repository;

use TodoList\User\Domain\Entity\User;
use TodoList\User\Domain\Repository\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}