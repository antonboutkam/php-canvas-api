<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FolderDeleteCommand extends Command
{
    function configure(): void
    {
        $this->setDescription('Folder delete command');
        $this->setHelp('Deletes a folder inside a course, the folder must be empty first.');
        $this->setName('folder:delete');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course.');
        $this->addArgument('folder_id', InputArgument::REQUIRED, 'The id of the folder to be deleted.');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iFolderId = $input->getArgument('folder_id');

        $oCanvas->deleteFolder($iCourseId, $iFolderId);

        return Command::SUCCESS;
    }

}