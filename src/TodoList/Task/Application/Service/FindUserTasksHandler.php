<?php

namespace App\TodoList\Task\Application\Service;


use App\TodoList\Task\Application\Query\FindUserTasksQuery;
use App\TodoList\Task\Domain\Repository\TaskRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FindUserTasksHandler implements MessageHandlerInterface
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

    public function __invoke(FindUserTasksQuery $findTasksQuery): string
    {
        $userId = $findTasksQuery->getUserId();

        $tasks = $this->taskRepository->findBy(['user' => $userId]);

        $results = [];

        if ($tasks) {
            foreach ($tasks as $task) {
                $results[$task->getId()->getUuid()] = $this->serializer->normalize($task, null, ['groups' => 'children']);

                /*$childTasks = $task->getChildren();
                if ($childTasks) {
                    $childTasksNormalized = [];
                    foreach ($childTasks as $children) {
                        $childTasksNormalized[] = $this->serializer->normalize($children);
                        $results[$task->getId()]['childTasks'] = $childTasksNormalized;
                    }
                }*/
            }
        } else {
            $results = ['results' => 'Task not exists'];
        }

        return json_encode($results, JSON_THROW_ON_ERROR);
    }
}