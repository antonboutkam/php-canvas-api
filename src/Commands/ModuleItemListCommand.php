<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleItemListCommand extends Command
{
    function configure():void
    {
        $this->setDescription('List all module items ');
        $this->setHelp('XXX');
        $this->setName('module-item:list');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'The id of the module');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iModuleId = $input->getArgument('module_id');

        $oModuleItemCollection = $oCanvas->getModuleItems($iCourseId, $iModuleId, 100);

        $table = new Table($output);
        $table->setHeaders(['Page id', 'Type', 'Page url', 'Title']);

        foreach ($oModuleItemCollection as $oModuleItem)
        {
            $table->addRow([$oModuleItem->getId(), $oModuleItem->getType(), $oModuleItem->getPageUrl(), $oModuleItem->getTitle()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}