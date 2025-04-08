<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuizQuestionGetCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a info about a question in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:question:get');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the Course');
        $this->addArgument('quiz_id', InputArgument::REQUIRED, 'The id of the Quiz');
        $this->addArgument('question_id', InputArgument::REQUIRED, 'The id of the question');

        // quiz:question:create
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $iCourseId = $input->getArgument('course_id');
        $iQuizId = $input->getArgument('quiz_id');
        $iQuizQuestionId = $input->getArgument('question_id');


        $oCanvas = new Canvas();
        $oQuizQuestion = $oCanvas->getQuizQuestion($iCourseId, $iQuizId, $iQuizQuestionId);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($oQuizQuestion as $key => $value) {
            if (is_array($value)) {
                $table->addRow([$key, json_encode($value)]);
            } else {
                $table->addRow([$key, $value]);
            }

        }
        $table->render();

        return Command::SUCCESS;
    }
}