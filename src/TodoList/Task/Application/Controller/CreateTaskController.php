<?php

namespace App\TodoList\Task\Application\Controller;


use App\TodoList\Task\Application\Event\OnTaskCreationRequestedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tasks', name: 'task_create', methods: ['POST'])]
class CreateTaskController extends AbstractController
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->eventDispatcher->dispatch(new OnTaskCreationRequestedEvent(
            $parameters['title'],
            $parameters['description'],
            $parameters['priority'],
            $parameters['status'],
            $parameters['user']
        ));

        return JsonResponse::fromJsonString(
            $request->getSession()->get('last_task_created')
        );
    }
}