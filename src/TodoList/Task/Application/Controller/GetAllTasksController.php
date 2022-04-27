<?php

namespace App\TodoList\Task\Application\Controller;


use App\TodoList\Task\Application\Query\FindAllTasksQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tasks', name: 'task_list_all', methods: ['GET'])]
class GetAllTasksController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(): JsonResponse
    {
        $task = $this->handle(new FindAllTasksQuery());

        return JsonResponse::fromJsonString($task);
    }
}