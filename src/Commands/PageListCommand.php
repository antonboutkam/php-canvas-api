<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PageListCommand extends Command
{
    function configure()
    {
        $this->setDescription('List all pages with their title and canvas Id');
        $this->setHelp('XXX');
        $this->setName('page:list');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');

        $oPageCollection = $oCanvas->getPages($iCourseId, 100);

        $table = new Table($output);
        $table->setHeaders(['Page id', 'Title', 'Page url']);

        foreach ($oPageCollection as $oPage)
        {
            $table->addRow([$oPage->getPageId(), $oPage->getTitle(), $oPage->getUrl()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}