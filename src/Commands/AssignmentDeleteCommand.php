<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AssignmentDeleteCommand extends Command
{
    use ItemPrintTrait;

    function configure()
    {
        $this->setDescription('Delete an assignment ');
        $this->setHelp('XXX');
        $this->setName('assignment:delete');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('assignment_id', InputArgument::REQUIRED, 'The canvas id of the assignment');
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
        $aAllowedExtensions = $input->getOption('allowed-extension');


        $oAssignment = new Assignment();
        $oAssignment->setCourseId($iCourseId);
        $oAssignment->setName($sName);
        $oAssignment->setDescription($sDescription);

        $oAssignment->setSubmissionTypes($sType);

        if(!empty($aAllowedExtensions))
        {
            $oAssignment->setAllowedExtensions($aAllowedExtensions);
        }

        $aResult = $oCanvas->createAssignment($iCourseId, $oAssignment);

        $this->printItem($aResult, $output);

        return Command::SUCCESS;
    }
}