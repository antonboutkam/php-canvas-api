<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Course\Course;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CourseCreateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Create a new course');
        $this->setHelp('XXX');
        $this->setName('course:create');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the course');
        $this->addArgument('code', InputArgument::REQUIRED, 'The code of the course');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oCourse = new Course();

        $sName = $input->getArgument('name');
        $sCode = $input->getArgument('code');


        $oCourse->setName($sName);
        $oCourse->setCourseCode($sCode);
        $oCourse->setIsPublic(false);

        $aCreatedCourse = $oCanvas->createCourse($oCourse);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCreatedCourse as $key => $value)
        {
            $table->addRow([$key, $value]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}