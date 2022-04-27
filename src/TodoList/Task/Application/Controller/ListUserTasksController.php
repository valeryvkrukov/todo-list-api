<?php

namespace App\TodoList\Task\Application\Controller;


use App\TodoList\Task\Application\Query\FindUserTasksQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/{userId}/tasks', name: 'task_get_user_tasks', methods: ['GET'])]
class ListUserTasksController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): JsonResponse
    {dd($request->get('userId'));
        $tasks = $this->handle(
            new FindUserTasksQuery(
                $request->get('userId')
            )
        );

        return JsonResponse::fromJsonString($tasks);
    }
}