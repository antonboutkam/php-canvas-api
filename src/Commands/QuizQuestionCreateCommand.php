<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Quiz\Quiz;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuizQuestionCreateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Create a new Quiz question in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:question:create');
        $this->addArgument('question_name', InputArgument::REQUIRED, 'The name of a question');
        $this->addArgument('question_text', InputArgument::REQUIRED, 'The text of a question.');
        $this->addArgument('quiz_group_id', InputArgument::REQUIRED, 'The id of a quiz question group.');
        $this->addArgument('points_possible', InputArgument::REQUIRED, 'The total point value given to the quiz. Must be positive.');
        $this->addArgument('grading_type', InputArgument::REQUIRED, 'The type of grading the assignment receives. (pass_fail, percent, letter_grade, gpa_scale, points)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oQuiz = new Quiz();
        // $oCanvas->createQuiz()
        $iCourseId = $input->getArgument('course_id');
        $oQuiz->setTitle($input->getArgument('title'));
        $oQuiz->setAssignmentGroupId($input->getArgument('assignment_group_id'));
        $oQuiz->setPointsPossible($input->getArgument('points_possible'));
        $oQuiz->setGradingType($input->getArgument('percent'));

        $output->write("Creating new Quiz <info>{$oQuiz->getTitle()}</info> in course <comment>{$iCourseId}</comment> ");
        $aCreatedQuiz = $oCanvas->createQuiz($iCourseId, $oQuiz);

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