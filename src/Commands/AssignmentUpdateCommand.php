<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentUpdateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Update an assignment');
        $this->setHelp('See: https://canvas.instructure.com/doc/api/assignments.html#method.assignments_api.create');
        $this->setName('assignment:update');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the assignment');
        $this->addArgument('description', InputArgument::REQUIRED, 'A description of the assignment');
        $this->addArgument('submission_type', InputArgument::REQUIRED, 'none, on_paper');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $sName = $input->getArgument('name');
        $sDescription = $input->getArgument('description');
        $sType = $input->getArgument('submission_type');
        $oAssignment = new Assignment();
        $oAssignment->setName($sName);
        $oAssignment->setDescription($sDescription);
        $oAssignment->setSubmissionTypes([$sType]);
        $aResult = $oCanvas->createAssignment($iCourseId, $oAssignment);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aResult as $key => $value)
        {
            $table->addRow([$key, $value]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}