<?php

namespace App\TodoList\User\Application\Command;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\TodoList\User\Application\Service\ListUsersService;

#[AsCommand(
    name: 'todo-list:list-users',
    description: 'List users of todo-list API.',
    hidden: false
)]
class ListUsersCommand extends Command
{
    private ListUsersService $listUsersService;

    public function __construct(ListUsersService $listUsersService)
    {
        $this->listUsersService = $listUsersService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setHelp('This command show users registered in API');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Users', '______________________________________', '',]);
        
        $users = $this->listUsersService->handle();

        foreach ($users as $user) {
            $output->writeln([
                'UUID: ' . $user->getId(), '',
                'Username: ' . $user->getUsername(),
                '______________________________________', '',
            ]);
        }

        return Command::SUCCESS;
    }
}
