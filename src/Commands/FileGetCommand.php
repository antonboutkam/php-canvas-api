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

class FileGetCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Get information about a specific file');
        $this->setHelp('These are files with course data, not student data');
        $this->setName('file:get:info');

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

        $oFileCollection = $oCanvas->getFiles($iCourseId);

        $table = new Table($output);
        $table->setHeaders(['File id', 'Content-type', 'Display name', 'Size', 'Url']);

        foreach ($oFileCollection as $oSubmission)
        {
            $table->addRow([
                $oSubmission->getId(),
                $oSubmission->getContentType(),
                $oSubmission->getDisplayName(),
                $oSubmission->getSize(),
                $oSubmission->getUrl()
                ]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}