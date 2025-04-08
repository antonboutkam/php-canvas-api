<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleItemCreateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Create a new module item ');
        $this->setHelp('XXX');
        $this->setName('module-item:create');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'The id of the module');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iModuleId = $input->getArgument('module_id');

        $oModuleItem = new ModuleItem();
        $oModuleItem->setTitle('Test page');
        $oModuleItem->setPublished(true);
        $oModuleItem->setType('Page');
        $oModuleItem->setContentId(29593805);
        $oModuleItem->setPageUrl('testing-123-3');

        $aData = $oCanvas->createModuleItem($iCourseId, $iModuleId, $oModuleItem);
        print_r($aData);
        return Command::SUCCESS;
    }
}