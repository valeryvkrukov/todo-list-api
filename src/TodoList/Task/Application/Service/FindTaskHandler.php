<?php

namespace App\TodoList\Task\Application\Service;


use App\TodoList\Task\Application\Query\FindTaskQuery;
use App\TodoList\Task\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FindTaskHandler implements MessageHandlerInterface
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

    public function __invoke(FindTaskQuery $findTaskQuery): string
    {
        $taskId = $findTaskQuery->getTaskId();

        $task = $this->taskRepository->find($taskId);

        $childTasksNormalized = [];

        if ($task) {
            foreach ($task->getChildren() as $children) {
                $childTasksNormalized[] = $this->serializer->normalize($children);
            }

            $results = array_merge(
                $this->serializer->normalize($task),
                ['childTasks' => $childTasksNormalized]
            );
        } else {
            $results = ['results' => 'Task not exists'];
        }

        return json_encode($results, JSON_THROW_ON_ERROR);
    }
}