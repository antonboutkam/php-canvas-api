<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class QuizQuestionListCommand extends Command
{
    function configure()
    {
        $this->setDescription('Get a info about a question in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:question:list');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the Course');
        $this->addArgument('quiz_id', InputArgument::REQUIRED, 'The id of the Quiz');

        // quiz:question:create
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $iCourseId = $input->getArgument('course_id');
        $iQuizId = $input->getArgument('quiz_id');


        $oCanvas = new Canvas();
        $oQuizQuestionCollection = $oCanvas->getQuizQuestions($iCourseId, $iQuizId);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($oQuizQuestionCollection as $oQuizQuestion) {
            print_r($oQuizQuestion->toArray());

        }
        $table->render();

        return Command::SUCCESS;
    }
}