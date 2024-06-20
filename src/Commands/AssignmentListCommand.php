<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentListCommand extends Command
{
    function configure()
    {
        $this->setDescription('List all assignments of a ');
        $this->setHelp('XXX');
        $this->setName('assignment:list');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');

        $oAssignmentCollection = $oCanvas->getAssignments($iCourseId, 100);

        $table = new Table($output);
        $table->setHeaders(['Page id', 'Title']);

        foreach ($oAssignmentCollection as $oAssignment)
        {
            $table->addRow([$oAssignment->getId(), $oAssignment->getName()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}