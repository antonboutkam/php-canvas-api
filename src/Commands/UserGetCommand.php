<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\User\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserGetCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a user by it\'s canvas ID.');
        $this->setHelp('XXX');
        $this->setName('user:get');
        $this->addArgument('user_id', InputArgument::REQUIRED, 'The canvas id of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iUserId = $input->getArgument('user_id');

        $oUser = User::fromCanvasArray($oCanvas->getUserProfile($iUserId));

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($oUser->toArray() as $key => $value)
        {
            $table->addRow([$key, $value]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}