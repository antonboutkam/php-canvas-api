<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroup;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentGroupUpdateCommand extends Command
{
    use ItemPrintTrait;

    function configure()
    {
        $this->setDescription('List all assignment groups that belong to a course');
        $this->setHelp('XXX');
        $this->setName('assignment-group:update');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('assignment_group_id', InputArgument::REQUIRED, 'The id of the assignment group');

        $this->addOption('name', 't', InputOption::VALUE_REQUIRED, 'The name of the assignment group');
        $this->addOption('position', 'p', InputOption::VALUE_REQUIRED, 'The position of the assignment group');
        $this->addOption('weight', 'w', InputOption::VALUE_REQUIRED, 'The percent of the total grade that this assignment group represents');

    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iAssignmentGroupId = $input->getArgument('assignment_group_id');

        $oAssignmentGroup = $oCanvas->getAssignmentGroup($iCourseId, $iAssignmentGroupId);

        if($sName = $input->getOption('name'))
        {
            $oAssignmentGroup->setName($sName);
        }
        if($sPosition = $input->getOption('position'))
        {
            $oAssignmentGroup->setPosition($sPosition);
        }
        if($sWeight = $input->getOption('weight'))
        {
            $oAssignmentGroup->setGroupWeight($sWeight);
        }

        $aResult = $oCanvas->updateAssignmentGroup($iCourseId, $iAssignmentGroupId, $oAssignmentGroup);

        $this->printItem($aResult, $output);

        return Command::SUCCESS;
    }
}