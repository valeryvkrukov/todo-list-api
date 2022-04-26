<?php

namespace TodoList\User\Domain\Event;


use TodoList\User\Domain\Entity\Username;
use TodoList\Shared\Event\DomainEventInterface;
use Symfony\Contracts\EventDispatcher\Event;

class UserCreatedEvent extends Event implements DomainEventInterface
{
    private string $userId;
    private Username $username;

    public function __construct(string $userId, Username $username)
    {
        $this->userId = $userId;
        $this->username = $username;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUsername(): Username
    {
        return $this->username;
    }
}