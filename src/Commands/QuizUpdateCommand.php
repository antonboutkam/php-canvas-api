<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Quiz\Quiz;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuizUpdateCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Change new Quiz in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:update');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the course.');
        $this->addArgument('assignment_group_id', InputArgument::REQUIRED, 'The assignment group id.');
        $this->addArgument('quiz_id', InputArgument::REQUIRED, 'The id of the quiz.');
        $this->addArgument('title', InputArgument::REQUIRED, 'The title of the quiz.');
        $this->addArgument('points_possible', InputArgument::REQUIRED, 'The total point value given to the quiz. Must be positive.');
        $this->addArgument('grading_type', InputArgument::REQUIRED, 'The type of grading the assignment receives. (pass_fail, percent, letter_grade, gpa_scale, points)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oQuiz = new Quiz();
        // $oCanvas->createQuiz()
        $iCourseId = $input->getArgument('course_id');
        $iQuizId = $input->getArgument('quiz_id');

        $oQuiz->setTitle($input->getArgument('title'));
        $oQuiz->setAssignmentGroupId($input->getArgument('assignment_group_id'));
        $oQuiz->setPointsPossible($input->getArgument('points_possible'));
        $oQuiz->setGradingType($input->getArgument('grading_type'));

        $output->write("Updating Quiz <comment>{$iQuizId}</comment> <info>{$oQuiz->getTitle()}</info> in course <comment>{$iCourseId}</comment> ");
        $aCreatedQuiz = $oCanvas->updateQuiz($iCourseId, $iQuizId, $oQuiz);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCreatedQuiz as $key => $value)
        {
            $table->addRow([$key, $value]);
        }
        $table->render();

        return Command::SUCCESS;
    }
}