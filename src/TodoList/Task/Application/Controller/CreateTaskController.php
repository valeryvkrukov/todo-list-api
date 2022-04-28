<?php

namespace App\TodoList\Task\Application\Controller;


use App\TodoList\Task\Application\Event\OnTaskCreationRequestedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/tasks', name: 'task_create', methods: ['POST'])]
class CreateTaskController extends AbstractController
{
    private EventDispatcherInterface $eventDispatcher;
    private SerializerInterface $serializer;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        SerializerInterface $serializer
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $parameters = json_decode($this->serializer->normalize(
                $request->getContent(), 
                null, 
                ['groups' => 'children']), 
                true
            );

        $this->eventDispatcher->dispatch(new OnTaskCreationRequestedEvent(
            $parameters['title'],
            $parameters['description'],
            $parameters['priority'],
            $parameters['status'],
            $parameters['user'],
            $parameters['parent'] ?? null
        ));

        return JsonResponse::fromJsonString(
            $request->getSession()->get('last_task_created')
        );
    }
}