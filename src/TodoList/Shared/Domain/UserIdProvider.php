<?php

namespace App\TodoList\Shared\Domain;


use App\TodoList\User\Domain\Entity\User;
use App\TodoList\User\Domain\Repository\UserRepositoryInterface;

class UserIdProvider implements UserIdProviderInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function byUuid(string $uuid): string
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(['id' => $uuid]);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User with ID %s not found', $uuid));
        }

        return $user->getId();
    }
} 