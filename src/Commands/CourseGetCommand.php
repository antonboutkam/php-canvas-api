<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CourseGetCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Get a single course by id');
        $this->setHelp('XXX');
        $this->setName('course:get');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');

        $oCourse = $oCanvas->getCourse($iCourseId);

        $aCourse = $oCourse->toArray();

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCourse as $key => $value)
        {
            $table->addRow([$key, $value]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}