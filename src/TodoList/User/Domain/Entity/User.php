<?php

namespace TodoList\User\Domain\Entity;


use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use TodoList\User\Domain\Entity\Username;
use TodoList\User\Infrastructure\Repository\UserRepository;
use TodoList\User\Domain\Event\UserCreatedEvent;
use TodoList\Shared\Aggregate\AggregateRoot;

#[ORM\Entity(repositoryClass: UserRepository::class, readOnly: false)]
class User extends AggregateRoot implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(type: "string", length: 32, unique: true, nullable: false)]
    private string $username;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        //
    }

    public static function createUser(Username $username): self
    {
        $userId = Uuid::uuid4()->toString();
        $user = new User($userId);
        $user->setUsername($username->getValue());

        $user->addDomainEvent(new UserCreatedEvent($userId, $username));

        return $user;
    }
}
