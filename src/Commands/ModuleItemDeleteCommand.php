<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleItemDeleteCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Delete a module item by id');
        $this->setHelp('XXX');
        $this->setName('module-item:delete');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'The canvas id of the module');
        $this->addArgument('item_id', InputArgument::REQUIRED, 'The canvas id of the module item');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iModuleId = $input->getArgument('module_id');
        $iItemId = $input->getArgument('item_id');

        $result = $oCanvas->deleteModule($iCourseId, $iModuleId);

        print_r($result);

        return Command::SUCCESS;
    }
}