<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserListCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a list of user by it\'s canvas ID.');
        $this->setHelp('XXX');
        $this->setName('user:list');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oUserCollection = $oCanvas->getUsersInAccount();

        $table = new Table($output);
        $table->setHeaders(['Name', 'Email']);
        foreach ($oUserCollection as $oUser) {
            $table->addRow([$oUser->getName(), $oUser->getEmail()]);
        }
        $table->render();

        return Command::SUCCESS;
    }
}