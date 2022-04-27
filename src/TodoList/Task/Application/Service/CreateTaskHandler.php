<?php

namespace App\TodoList\Task\Application\Service;


use App\TodoList\Task\Application\Command\CreateTaskCommand;
use App\TodoList\Task\Domain\Entity\Task;
use App\TodoList\Task\Domain\Entity\TaskId;
use App\TodoList\Task\Domain\Entity\TaskPriority;
use App\TodoList\Task\Domain\Entity\TaskStatus;
use App\TodoList\Task\Domain\Repository\TaskRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CreateTaskHandler implements MessageHandlerInterface
{
    private TaskRepositoryInterface $taskRepository;
    private EventDispatcherInterface $eventDispatcher;
    private SerializerInterface $serializer;
    private RequestStack $requestStack;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer,
        RequestStack $requestStack
    ) {
        $this->taskRepository = $taskRepository;
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function __invoke(CreateTaskCommand $createTaskCommand): void
    {
        $task = Task::create(
            new TaskId(Uuid::uuid4()->toString()),
            $createTaskCommand->getTitle(),
            $createTaskCommand->getDescription(),
            new TaskPriority($createTaskCommand->getPriority()),
            new TaskStatus($createTaskCommand->getStatus())
        );

        $this->taskRepository->save($task);

        $this->requestStack->getSession()->set(
            'last_task_created',
            $this->serializer->serialize($task, 'json')
        );

        foreach ($task->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
    }
}