<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Page\Page;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PageCreateCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Create a modules within a course');
        $this->setHelp('XXX');
        $this->setName('page:create');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oPage = new Page();
        $oPage->setTitle('"Testing 123"');
        $oPage->setBody('<h2>Hoi hoi hoi</h2>');
       //  $oPage->setPublished(true);
       // $oPage->setPosition(4);
        // $oPage->setPublishFinalGrade(false);

        print_r($oPage->toCanvasArray());
        $iCourseId = $input->getArgument('course_id');
        $oCanvas = new Canvas();
        $output->writeln("Create new page <comment>{$oPage->getTitle()}</comment>");

        $aResponse =  $oCanvas->createPage($iCourseId, $oPage);
        $output->writeln("Module <comment>{$oPage->getTitle()}</comment> created");
        print_r($aResponse);

        return Command::SUCCESS;
    }
}