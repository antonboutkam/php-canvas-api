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

        $oStudentCollection = $oCanvas->getStudentsInCourse($iCourseId);

        $table = new Table($output);
        $table->setHeaders(['Id', 'Name', 'Sortable name', 'Login id']);


        foreach ($oStudentCollection as $oStudent) {
            $table->addRow([$oStudent->getId(),
                $oStudent->getName(),
                $oStudent->getSortableName(),
                $oStudent->getLoginId()]);

        }
        $table->render();

        return Command::SUCCESS;
        /*

        foreach ($aCourse as $key => $value)
        {

        }

        $table->render();

        return Command::SUCCESS;
        */
    }
}