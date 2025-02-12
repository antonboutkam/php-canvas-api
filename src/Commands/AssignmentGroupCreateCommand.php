<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroup;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentGroupCreateCommand extends Command
{
    use ItemPrintTrait;
    function configure()
    {
        $this->setDescription('Create a new assignment ');
        $this->setHelp('XXX');
        $this->setName('assignment-group:create');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the assignment');
        $this->addArgument('position', InputArgument::OPTIONAL, 'The position of the assignment group', 1);
        $this->addArgument('weight', InputArgument::OPTIONAL, 'The percent of the total grade that this assignment group represents', 100);

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
        $iPosition = $input->getArgument('position');
        $iWeight = $input->getArgument('weight');

        $oAssignmentGroup = new AssignmentGroup();
        $oAssignmentGroup->setName($sName);
        $oAssignmentGroup->setPosition($iPosition);
        $oAssignmentGroup->setCourseId($iCourseId);
        $oAssignmentGroup->setGroupWeight($iWeight);

        $aResult = $oCanvas->createAssignmentGroup($iCourseId, $oAssignmentGroup);

        $this->printItem($aResult, $output);

        return Command::SUCCESS;
    }
}