<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PageGetCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a single course by id');
        $this->setHelp('XXX');
        $this->setName('page:get');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('page_id', InputArgument::REQUIRED, 'The id of the page');

    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $iCourseId = $input->getArgument('course_id');
        $iPageId = $input->getArgument('page_id');

        $oPage = $oCanvas->getPage($iCourseId, $iPageId);

        $aPage = $oPage->toArray();

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aPage as $key => $value)
        {
            if($value instanceof \DateTime)
            {
                $value = $value->format(\DateTime::ATOM);
            }
            elseif(is_array($value))
            {
                $value = substr(json_encode($value),0, 50);
            }
            $table->addRow([$key, $value]);
        }

        $table->render();

        return Command::SUCCESS;
    }
}