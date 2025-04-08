<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
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

        $iCourseId = $input->getArgument('course_id');
        $oQuizCollection = $oCanvas->getQuizzes($iCourseId);

        $table = new Table($output);
        $table->setHeaders(['Id', 'Name', 'PointsPossible']);

        foreach ($oQuizCollection as $key => $oQuiz)
        {
            $table->addRow([$oQuiz->getId(), $oQuiz->getTitle(), $oQuiz->getPointsPossible()]);
        }
        $table->render();

        return Command::SUCCESS;
    }
}