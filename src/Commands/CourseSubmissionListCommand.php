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

class CourseSubmissionListCommand extends Command
{
    function configure()
    {
        $this->setDescription('List all open submissions that belong to a course ');
        $this->setHelp('XXX');
        $this->setName('course:submission:list');

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
        $oSubmissionCollection = $oCanvas->getCourseSubmissions($iCourseId, 'submitted');

        $table = new Table($output);
        $table->setHeaders(['Page id', 'Type', 'Workflow state', 'User id']);

        foreach ($oSubmissionCollection as $oSubmission)
        {
            $table->addRow([
                $oSubmission->getId(),
                $oSubmission->getSubmissionType(),
                $oSubmission->getWorkflowState(),
                $oSubmission->getUserId()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}