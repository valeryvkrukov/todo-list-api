<?php

namespace App\TodoList\Task\Domain\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Shared\Aggregate\AggregateRoot;
use App\TodoList\Task\Domain\Event\TaskCreatedEvent;
use App\TodoList\Task\Infrastructure\Repository\TaskRepository;

#[ORM\Entity(repositoryClass: TaskRepository::class, readOnly: false)]
class Task extends AggregateRoot
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(type: "string", length: 180, nullable: false)]
    private string $title;

    #[ORM\Column(type: "text", nullable: true)]
    private string $description;

    #[ORM\Column(type: "smallint", nullable: false)]
    private int $priority;

    #[ORM\Column(type: "string", length: 25, nullable: false)]
    private string $status;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: "children")]
    #[ORM\JoinColumn(name: "parent", referencedColumnName: "id")]
    private $parent;

    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: "parent")]
    private Collection $children;

    #[ORM\Column(type: "date_immutable")]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "date_immutable")]
    private \DateTimeImmutable $updatedAt;

    public function __construct(TaskId $id) {
        $this->id = $id->getUuid();
        $this->children = new ArrayCollection();
    }

    public function getId(): ?TaskId
    {
        return new TaskId($this->id);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriority(): TaskPriority
    {
        return new TaskPriority($this->priority);
    }

    public function setPriority(TaskPriority $priority): self
    {
        $this->priority = $priority->getValue();

        return $this;
    }

    public function getStatus(): TaskStatus
    {
        return new TaskStatus($this->status);
    }

    public function setStatus(TaskStatus $status): self
    {
        $this->status = $status->getValue();

        return $this;
    }

    public function getParent(): ?Task
    {
        return $this->parent;
    }

    public function setParent(Task $parent): self
    {
       $this->parent = $parent;

       return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Task $child): Task
    {
       $this->children[] = $child;
       
       $child->setParent($this);

       $task->addDomainEvent(new TaskChildAddedEvent($child));

       return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public static function create(
        TaskId $taskId,
        string $title,
        string $description,
        TaskPriority $priority,
        TaskStatus $status
    ): self {
        $task = new self($taskId);
        $task->setTitle($title);
        $task->setDescription($description);
        $task->setPriority($priority);
        $task->setStatus($status);
        $task->setCreatedAt(new \DateTimeImmutable('now'));
        $task->setUpdatedAt(new \DateTimeImmutable('now'));

        $task->addDomainEvent(new TaskCreatedEvent($taskId));

        return $task;
    }
}