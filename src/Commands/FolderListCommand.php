<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FolderListCommand extends Command
{
    function configure():void
    {
        $this->setDescription('List all folders in a course');
        $this->setHelp('These are folders with course data, not student data');
        $this->setName('folder:list');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');

        $oFolderCollection = $oCanvas->getFolders($iCourseId);

        $table = new Table($output);
        $table->setHeaders(['Page id', 'Name', 'Position', 'File count']);

        foreach ($oFolderCollection as $oFolder)
        {
            $table->addRow([
                $oFolder->getId(),
                $oFolder->getName(),
                $oFolder->getPosition(),
                $oFolder->getFilesCount(),
                $oFolder->getContextType(),
                $oFolder->getCreatedAt()]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}