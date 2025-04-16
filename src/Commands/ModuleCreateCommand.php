<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Module\Module;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleCreateCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Create a modules within a course');
        $this->setHelp('XXX');
        $this->setName('module:create');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oModule = new Module();
        $oModule->setName('Testing 123');
       //  $oModule->setPublished(true);
       // $oModule->setPosition(4);
        // $oModule->setPublishFinalGrade(false);

        $iCourseId = $input->getArgument('course_id');
        $oCanvas = new Canvas();
        $output->writeln("Create new module <comment>{$oModule->getName()}</comment>");

        $aResponse =  $oCanvas->createModule($iCourseId, $oModule);
        $output->writeln("Module <comment>{$oModule->getName()}</comment> created");
        print_r($aResponse);

        return Command::SUCCESS;
    }
}