<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Quiz\Quiz;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuizListCommand extends Command
{
    function configure()
    {
        $this->setDescription('Show quizzes in a course');
        $this->setHelp('XXX');
        $this->setName('quiz:list');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the course.');
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
        $oQuiz->setGradingType($input->getArgument('percent'));

        $output->write("Updating Quiz <comment>{$iQuizId}</comment> <info>{$oQuiz->getTitle()}</info> in course <comment>{$iCourseId}</comment> ");
        $aCreatedQuiz = $oCanvas->getQuizzes($iCourseId);

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