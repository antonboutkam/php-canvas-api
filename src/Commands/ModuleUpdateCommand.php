<?php

namespace Hurah\Canvas\Commands;

use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleUpdateCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Update a modules within a course');
        $this->setHelp('XXX');
        $this->setName('module:update');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The course id of the course');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'The id of the module');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $iCourseId = $input->getArgument('course_id');
        $iModuleId = $input->getArgument('module_id');

        $oCanvas = new Canvas();
        $oCanvasModuleCollection = $oCanvas->getModules($iCourseId);
        foreach ($oCanvasModuleCollection as $oCanvasModule)
        {
            $output->writeln("Update module: <comment>{$oCanvasModule->getName()}</comment>");
            $oCanvasModule->setPublished(true);
            $oCanvas->updateModule($iCourseId, $iModuleId, $oCanvasModule);
        }



        return Command::SUCCESS;
    }
}