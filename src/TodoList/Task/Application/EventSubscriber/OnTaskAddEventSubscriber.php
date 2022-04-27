<?php

namespace App\TodoList\Task\Application\EventSubscriber;


use App\TodoList\Task\Application\Command\CreateTaskCommand;
use App\TodoList\Task\Application\Event\OnTaskCreationRequestedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class OnTaskAddEventSubscriber implements EventSubscriberInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
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

        $this->messageBus->dispatch($createTaskCommand);
    }
}