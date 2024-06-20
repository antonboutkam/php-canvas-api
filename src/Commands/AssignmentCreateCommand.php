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

class AssignmentCreateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Create a new assignment ');
        $this->setHelp('XXX');
        $this->setName('assignment:create');
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

        $oAssignment = new Assignment();
        $oAssignment->setName('Test assignment');

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