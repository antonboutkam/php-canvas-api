<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PageDeleteCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Delete a page by id');
        $this->setHelp('XXX');
        $this->setName('page:delete');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('page_id', InputArgument::REQUIRED, 'The canvas id of the page');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iPageId = $input->getArgument('page_id');

        $result = $oCanvas->deletePage($iCourseId, $iPageId);

        print_r($result);

        return Command::SUCCESS;
    }
}