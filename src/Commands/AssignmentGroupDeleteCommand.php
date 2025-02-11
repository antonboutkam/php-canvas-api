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

class AssignmentGroupDeleteCommand extends Command
{
    use ItemPrintTrait;

    function configure()
    {
        $this->setDescription('Deletes an assignent group');
        $this->setHelp('XXX');
        $this->setName('assignment-group:delete');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('assignment_group_id', InputArgument::REQUIRED, 'The id of the assignment group');
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

        $aResult = $oCanvas->deleteAssignmentGroup($iCourseId, $iAssignmentGroupId);
        $this->printItem($aResult, $output);

        return Command::SUCCESS;
    }
}