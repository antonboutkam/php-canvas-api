<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MasteryPathSelectCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Select mastery path assignment set for a module item');
        $this->setHelp('Posts to /courses/:course_id/modules/:module_id/items/:id/select_mastery_path');
        $this->setName('mastery-path:select');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'Canvas course id');
        $this->addArgument('module_id', InputArgument::REQUIRED, 'Canvas module id');
        $this->addArgument('module_item_id', InputArgument::REQUIRED, 'Canvas module item id');
        $this->addArgument('assignment_set_id', InputArgument::REQUIRED, 'Assignment set id to select');
        $this->addArgument('student_id', InputArgument::OPTIONAL, 'Optional student id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $canvas = new Canvas();

        $courseId = (int)$input->getArgument('course_id');
        $moduleId = (int)$input->getArgument('module_id');
        $moduleItemId = (int)$input->getArgument('module_item_id');
        $assignmentSetId = (string)$input->getArgument('assignment_set_id');
        $studentId = $input->getArgument('student_id');
        $studentId = $studentId === null ? null : (int)$studentId;

        $result = $canvas->selectMasteryPath($courseId, $moduleId, $moduleItemId, $assignmentSetId, $studentId);
        $output->writeln(json_encode($result, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }
}
