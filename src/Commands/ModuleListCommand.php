<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleListCommand extends Command
{
    function configure()
    {
        $this->setDescription('List all modules within a course');
        $this->setHelp('XXX');
        $this->setName('module:list');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $iCourseId = $input->getArgument('course_id');
        $oCanvas = new Canvas();
        $oModuleCollection = $oCanvas->getModules($iCourseId, 100);

        $table = new Table($output);
        $table->setHeaderTitle("Modules in course {$iCourseId}");
        $table->setHeaders(['Module Id', 'Name']);

        foreach ($oModuleCollection as $oModule)
        {
            $table->addRow([$oModule->getId(), $oModule->getName()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}