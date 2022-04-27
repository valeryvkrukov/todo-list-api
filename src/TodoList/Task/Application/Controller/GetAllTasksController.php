<?php

namespace App\TodoList\Task\Application\Controller;


use App\TodoList\Task\Application\Query\FindTaskQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/task/{id}', name: 'task_list', methods: ['GET'])]
class GetAllTasksController extends AbstractController
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function __invoke(string $id): JsonResponse
    {
        $task = $this->handle(new FindTaskQuery($id));

        return JsonResponse::fromJsonString($task);
    }
}