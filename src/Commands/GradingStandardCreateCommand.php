<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\GradingStandard\GradingStandard;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GradingStandardCreateCommand extends Command
{
    /**
     * Renamed grading standards
     * @return void
     */
    function configure():void
    {
        $this->setDescription('Create a new grading standard');
        $this->setHelp('XXX');
        $this->setName('grading:standard:create');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the course');
        $this->addArgument('code', InputArgument::REQUIRED, 'The code of the course');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oGradingStandard = new GradingStandard();

        $oGradingStandard->setTitle('1 t/m 10');
        $oGradingStandard->setPointsBased(true);

        /*
        $oGradingStandard->setGradingScheme()
        $oCourse->setName($sName);
        $oCourse->setCourseCode($sCode);
        $oCourse->setIsPublic(false);

        $aCreatedCourse = $oCanvas->createGradingStandard($oGradingStandard);
                $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCreatedCourse as $key => $value)
        {
            $table->addRow([$key, $value]);
        }


        $table->render();

*/

        return Command::SUCCESS;
    }
}