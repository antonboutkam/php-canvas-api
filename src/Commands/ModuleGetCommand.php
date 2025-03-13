<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleGetCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a module from a course');
        $this->setHelp('XXX');
        $this->setName('module:get');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'The canvas id of the module');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $iCourseId = $input->getArgument('course_id');
        $iModuleId = $input->getArgument('module_id');

        $oCanvas = new Canvas();
        $oModule = $oCanvas->getModule($iCourseId, $iModuleId);
        $aModule = $oModule->toArray();

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aModule as $key => $value)
        {
            $table->addRow([$key, $value]);
        }

        $table->render();


        return Command::SUCCESS;
    }
}