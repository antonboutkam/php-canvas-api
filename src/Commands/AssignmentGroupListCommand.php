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
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentGroupListCommand extends Command
{
    function configure():void
    {
        $this->setDescription('List all assignment groups that belong to a course');
        $this->setHelp('XXX');
        $this->setName('assignment-group:list');
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

        $aResult = $oCanvas->getAssignmentGroups($iCourseId);
        
        $table = new Table($output);
        $table->setHeaders(['Id', 'Name', 'Position', 'GroupWeight']);

        foreach ($aResult as $key => $oAssignmentGroup)
        {
            if($oAssignmentGroup instanceof AssignmentGroup)
            {
                $table->addRow([
                    $oAssignmentGroup->getId(),
                    $oAssignmentGroup->getName(),
                    $oAssignmentGroup->getPosition(),
                    $oAssignmentGroup->getGroupWeight()
                ]);
            }
        }

        $table->render();

        return Command::SUCCESS;
    }
}