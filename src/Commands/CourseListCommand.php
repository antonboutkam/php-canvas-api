<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CourseListCommand extends Command
{
    function configure():void
    {
        $this->setDescription('List all courses with their Canvas Id');
        $this->setHelp('XXX');
        $this->setName('course:list');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oCourseCollection = $oCanvas->getCourses(100);

        $table = new Table($output);
        $table->setHeaders(['Course Id', 'Name', 'Account ID']);

        foreach ($oCourseCollection as $oCourse)
        {
            $table->addRow([$oCourse->getId(), $oCourse->getName(), $oCourse->getAccountId()]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}