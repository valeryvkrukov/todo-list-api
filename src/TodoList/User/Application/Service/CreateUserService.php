<?php

namespace App\TodoList\User\Application\Service;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\TodoList\User\Domain\Entity\User;
use App\TodoList\User\Domain\Entity\Username;
use App\TodoList\User\Domain\Repository\UserRepositoryInterface;

class CreateUserService
{
    private UserRepositoryInterface $userRepository;
    private EventDispatcherInterface $eventDispatcher;
    private SerializerInterface $serializer;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function handle(string $username): string
    {
        $user = User::createUser(new Username($username));

        $this->userRepository->save($user);

        foreach ($user->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }

        return $this->serializer->serialize($user, 'json');
    }
}