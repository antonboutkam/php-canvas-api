<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModuleItemSequenceGetCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Get module item sequence and mastery path state for a course asset');
        $this->setHelp('Fetches /courses/:course_id/module_item_sequence');
        $this->setName('module-item-sequence:get');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'Canvas course id');
        $this->addArgument('asset_type', InputArgument::REQUIRED, 'Asset type, for example ModuleItem');
        $this->addArgument('asset_id', InputArgument::REQUIRED, 'Asset id');
        $this->addArgument('student_id', InputArgument::OPTIONAL, 'Optional student id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $canvas = new Canvas();
        $courseId = (int)$input->getArgument('course_id');
        $assetType = (string)$input->getArgument('asset_type');
        $assetId = (string)$input->getArgument('asset_id');
        $studentId = $input->getArgument('student_id');
        $studentId = $studentId === null ? null : (int)$studentId;

        $sequence = $canvas->getModuleItemSequence($courseId, $assetType, $assetId, $studentId);
        $output->writeln(json_encode($sequence->toCanvasArray(), JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
