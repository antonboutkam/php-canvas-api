<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentUpdateCommand extends Command
{
    use ItemPrintTrait;

    function configure():void
    {
        $this->setDescription('Create a new assignment ');
        $this->setHelp('XXX');
        $this->setName('assignment:update');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('assignment_id', InputArgument::REQUIRED, 'The canvas id of the assignment');

        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the assignment');
        $this->addArgument('description', InputArgument::REQUIRED, 'A description of the assignment');
        $this->addArgument('submission_type', InputArgument::OPTIONAL, 'Allowed options are: online_quiz, none, on_paper, discussion_topic, external_tool, online_upload, online_text_entry, online_url, media_recording, student_annotation', 'none');
        $this->addOption('allowed-extension', 'e', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Allowed extensions, may be used multiple times eg: --allowed-extension=pdf --allowed-extension=txt');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iAssignmentId = $input->getArgument('assignment_id');


        $sName = $input->getArgument('name');
        $sDescription = $input->getArgument('description');
        $sType = $input->getArgument('submission_type');
        $aAllowedExtensions = $input->getOption('allowed-extension');


        $oAssignment = $oCanvas->getAssignment($iCourseId, $iAssignmentId);

        $oAssignment->setName($sName);
        $oAssignment->setDescription($sDescription);
        $oAssignment->setSubmissionTypes($sType);


        $aResult = $oCanvas->updateAssignment($iCourseId, $iAssignmentId, $oAssignment);

        $this->printItem($aResult, $output);

        return Command::SUCCESS;
    }
}