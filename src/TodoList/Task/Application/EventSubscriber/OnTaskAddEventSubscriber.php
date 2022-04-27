<?php

namespace App\TodoList\Task\Application\EventSubscriber;


use App\TodoList\Shared\Domain\UserIdProviderInterface;
use App\TodoList\Task\Application\Command\CreateTaskCommand;
use App\TodoList\Task\Application\Event\OnTaskCreationRequestedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OnTaskAddEventSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;
    private UserIdProviderInterface $userIdProvider;

    public function __construct(
        MessageBusInterface $messageBus,
        UserIdProviderInterface $userIdProvider
    ) {
        $this->messageBus = $messageBus;
        $this->userIdProvider = $userIdProvider;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            OnTaskCreationRequestedEvent::class => 'createTask',
        ];
    }

    public function createTask(OnTaskCreationRequestedEvent $event): void
    {
        $createTaskCommand = new CreateTaskCommand();
        $createTaskCommand->setTitle($event->getTitle());
        $createTaskCommand->setDescription($event->getDescription());
        $createTaskCommand->setPriority($event->getPriority());
        $createTaskCommand->setStatus($event->getStatus());
        $createTaskCommand->setUser(
            $this->userIdProvider->byUuid($event->getUser())
        );

        $this->messageBus->dispatch($createTaskCommand);
    }
}