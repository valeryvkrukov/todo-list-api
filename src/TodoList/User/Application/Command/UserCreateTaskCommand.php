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
    name: 'todo-list:create-task',
    description: 'Make API call using cURL to api and create task for user UUID.',
    hidden: false
)]
class UserCreateTaskCommand extends Command
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
            ->setHelp('This command create new task for user using cURL call to API')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('title', InputArgument::REQUIRED, 'Task title')
            ->addArgument('description', InputArgument::REQUIRED, 'Task description')
            ->addArgument('priority', InputArgument::REQUIRED, 'Task priority')
            ->addArgument('status', InputArgument::REQUIRED, 'Task status')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');

        $output->writeln(['Creating Task for: ' . $username, '============', '']);
        
        $user = $this->userRepository->findOneBy(['username' => $username]);

        if ($user) {
            $requestJson = json_encode([
                'title' => $input->getArgument('title'),
                'description' => $input->getArgument('description'),
                'priority' => $input->getArgument('priority'),
                'status' => $input->getArgument('status'),
                'user' => $user->getId(),
            ], JSON_THROW_ON_ERROR);

            $response = $this->client->request(
                'POST',
                sprintf('%s/api/tasks', self::API_HOST),
                [
                    'headers' => [
                        'Content-Type: application/json',
                        'Accept: application/json',
                    ],
                    'body' => $requestJson,
                ]
            );

            if ($response->getStatusCode() === 200) {
                $output->write(sprintf(
                    'Task %s for user %s created.', 
                    $input->getArgument('title'),
                    $username
                ));
            }
        }

        return Command::SUCCESS;
    }
}
