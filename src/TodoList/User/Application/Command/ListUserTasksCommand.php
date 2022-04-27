<?php

namespace App\TodoList\User\Application\Command;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\TodoList\User\Domain\Repository\UserRepositoryInterface;

#[AsCommand(
    name: 'todo-list:tasks-list',
    description: 'Make API call using cURL to api list tasks for given user UUID.',
    hidden: false
)]
class ListUserTasksCommand extends Command
{
    const API_HOST = 'https://127.0.0.1:8000';

    private HttpClientInterface $client;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        HttpClientInterface $client,
        UserRepositoryInterface $userRepository
    ) {
        $this->client = $client;
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('Make API call using cURL to api list tasks for given user UUID.')
            ->addArgument('uuid', InputArgument::REQUIRED, 'User UUID')
            ->addArgument('status', InputArgument::REQUIRED, 'Task status (todo|done)')
            ->addArgument('priority', InputArgument::REQUIRED, 'Task priority (1..5)')
            ->addArgument('sortBy', InputArgument::REQUIRED, 'Sort by (created|done|priority)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $uuid = $input->getArgument('uuid');

        $user = $this->userRepository->findOneBy(['id' => $uuid]);

        if ($user) {
            
        }

        return Command::SUCCESS;
    }
}