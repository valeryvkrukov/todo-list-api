<?php

namespace App\TodoList\Task\Application\Service;


use App\TodoList\Task\Application\Query\FindAllTasksQuery;
use App\TodoList\Task\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FindAllTasksHandler implements MessageHandlerInterface
{
    private TaskRepositoryInterface $taskRepository;
    private SerializerInterface $serializer;

    public function __construct(
        TaskRepositoryInterface $taskRepository,
        SerializerInterface $serializer
    ) {
        $this->taskRepository = $taskRepository;
        $this->serializer = $serializer;
    }

    public function __invoke(FindAllTasksQuery $findTasksQuery): string
    {
        //$tasks = $findTasksQuery->getTasks();

        $tasks = $this->taskRepository->findAll();

        $childTasksNormalized = [];

        $results = [];

        if ($tasks) {
            foreach ($tasks as $task) {
                $childTasks = $task->getChildren();
                if ($childTasks) {
                    foreach ($childTasks as $children) {
                        $childTasksNormalized[] = $this->serializer->normalize($children);
                    }

                    $results[$task->getId()->getUuid()] = array_merge(
                        $this->serializer->normalize($task),
                        ['childTasks' => $childTasksNormalized]
                    );
                }
            }
        }

        return json_encode($results, JSON_THROW_ON_ERROR);
    }
}