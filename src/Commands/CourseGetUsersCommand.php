<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CourseGetUsersCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Get all users assigned to a course');
        $this->setHelp('XXX');
        $this->setName('course:get:users');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');

        $oCourse = $oCanvas->getCourseUsers($iCourseId);

        $aUsers = $oCourse->toArray();
print_r($aUsers);
        return Command::SUCCESS;
        /*
        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCourse as $key => $value)
        {
            $table->addRow([$key, $value]);
        }

        $table->render();

        return Command::SUCCESS;
        */
    }
}