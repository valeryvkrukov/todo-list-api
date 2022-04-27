<?php

namespace App\TodoList\User\Application\Service;


use Doctrine\Common\Collections\Collection;
use App\TodoList\User\Domain\Entity\User;
use App\TodoList\User\Domain\Entity\Username;
use App\TodoList\User\Domain\Repository\UserRepositoryInterface;

class ListUsersService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(): array
    {
        return $this->userRepository->findAll();
    }
}