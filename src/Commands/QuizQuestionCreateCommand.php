<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\QuizQuestion\QuizQuestion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QuizQuestionCreateCommand extends Command
{
    function configure():void
    {
        $this->setDescription('Create a new Quiz question in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:question:create');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the Course');
        $this->addArgument('quiz_id', InputArgument::REQUIRED, 'The id of the Quiz');

        $this->addArgument('question_type', InputArgument::REQUIRED, 'Allowed values: calculated_question, essay_question, file_upload_question, fill_in_multiple_blanks_question, matching_question, multiple_answers_question, multiple_choice_question, multiple_dropdowns_question, numerical_question, short_answer_question, text_only_question, true_false_question');
        $this->addArgument('question_name', InputArgument::REQUIRED, 'The name of a question');
        $this->addArgument('question_text', InputArgument::REQUIRED, 'The text of a question.');


        $this->addArgument('points_possible', InputArgument::REQUIRED, 'The total point value given to the quiz. Must be positive.');

        $this->addArgument('correct_comments', InputArgument::REQUIRED, 'Comments when the question was answered correctly.');
        $this->addArgument('incorrect_comments', InputArgument::REQUIRED, 'Comments when the question was answered incorrectly.');
        $this->addArgument('neutral_comments', InputArgument::OPTIONAL, 'Neutral comments');

        $this->addOption('answer', 'a', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'An answer, can be added multiple times');
        $this->addOption('position', 'p', InputOption::VALUE_REQUIRED, 'Specifies the order of questions in the Quiz');
        $this->addOption('quiz_group_id', 'g', InputOption::VALUE_REQUIRED, 'The id of a quiz question group.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $oCanvas = new Canvas();
        $oQuizQuestion = new QuizQuestion();
        $iCourseId = $input->getArgument('course_id');
        $iQuizId = $input->getArgument('quiz_id');

        $oQuizQuestion->setQuestionName($input->getArgument('question_name'));
        $oQuizQuestion->setQuestionText($input->getArgument('question_text'));
        $oQuizQuestion->setQuestionType($input->getArgument('question_type'));
        $oQuizQuestion->setPointsPossible((float)$input->getArgument('points_possible'));

        $oQuizQuestion->setCorrectComments($input->getArgument('correct_comments'));
        $oQuizQuestion->setIncorrectComments($input->getArgument('incorrect_comments'));
        $oQuizQuestion->setNeutralComments($input->getArgument('neutral_comments'));

        // $oQuizQuestion->setAnswers($input->getOption('answer'));
        $oQuizQuestion->setPosition($input->getOption('position'));
        // $oQuizQuestion->setAnswers();
        // $oQuizQuestion->setQuizGroupId();

        $output->write("Creating <info>{$oQuizQuestion->getQuestionName()}</info> new QuizQuestion <info>{$oQuizQuestion->getId()}</info> in course <comment>{$iCourseId}</comment> ");
        $aCreatedQuiz = $oCanvas->createQuizQuestion($iCourseId, $iQuizId, $oQuizQuestion);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCreatedQuiz as $key => $value)
        {
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