<?php

namespace TodoList\User\Application\Command;


use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TodoList\User\Application\Service\CreateUserService;

#[AsCommand(
    name: 'todo-list:create-user',
    description: 'Creates a new user for todo-list API.',
    aliases: ['todo-list:add-user'],
    hidden: false
)]
class CreateUserCommand extends Command
{
    private CreateUserService $createUserService;

    public function __construct(CreateUserService $createUserService)
    {
        $this->createUserService = $createUserService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows to create a simple user')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['Creating User', '============', '']);
        
        $user = $this->createUserService->handle($input->getArgument('username'));

        $output->writeln(['User created : ', '']);
        $output->write($user);

        return Command::SUCCESS;
    }
}
