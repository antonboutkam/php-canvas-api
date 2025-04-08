<?php

namespace Hurah\Canvas\Commands;

use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Quiz\Quiz;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QuizCreateCommand extends Command
{
    function configure()
    {
        $this->setDescription('Create a new Quiz in a Course');
        $this->setHelp('XXX');
        $this->setName('quiz:create');
        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the course.');
        $this->addArgument('assignment_group_id', InputArgument::REQUIRED, 'The assignment group id.');
        $this->addArgument('title', InputArgument::REQUIRED, 'The title of the quiz.');

        $this->addArgument('points_possible', InputArgument::REQUIRED, 'The total point value given to the quiz. Must be positive.');
        // $this->addArgument('grading_type', InputArgument::REQUIRED, 'The type of grading the assignment receives. (pass_fail, percent, letter_grade, gpa_scale, points)');
        $this->addArgument('scoring_policy', InputArgument::OPTIONAL, 'Required and only valid if allowed_attempts > 1. Scoring policy for a quiz that students can take multiple times. Defaults to “keep_highest”.. (keep_highest, keep_latest)');
        $this->addOption('time_limit', 't', InputOption::VALUE_REQUIRED, 'Time limit to take this quiz, in minutes. Set to null for no time limit. Defaults to null..');
        $this->addOption('hide_results', null, InputOption::VALUE_REQUIRED, 'Dictates whether or not quiz results are hidden from students. If null, students can see their results after any attempt. If “always”, students can never see their results. If “until_after_last_attempt”, students can only see results after their last attempt. (Only valid if allowed_attempts > 1). Defaults to null.');

        $this->addOption('shuffle_answers', 's', InputOption::VALUE_REQUIRED, 'Enables answer shuffeling', false);
        $this->addOption('access_code', 'a', InputOption::VALUE_REQUIRED, 'Accepts not value, if specified answers will not be shuffeled, answers are shuffeled by default.', false);
        $this->addOption('description', 'd', InputOption::VALUE_REQUIRED, 'Description text for this Quiz', false);
        $this->addOption('published', 'p', InputOption::VALUE_REQUIRED, 'Any value other then 0 will publish the course immediately', false);


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
        $oQuiz->setScoringPolicy($input->getArgument('scoring_policy'));
        $oQuiz->setDescription($input->getOption('description'));
        $oQuiz->setPermissions(['read' => true]);
        $oQuiz->setAccessCode($input->getOption('access_code'));

        $oQuiz->setPublished($input->getOption('published'));
        $oQuiz->setLockedForUser(false);

        if ($sTimeLimit = (int)$input->getOption('time_limit')) {
            $oQuiz->setTimeLimit($sTimeLimit);
        }
        if ($sHideResults = $input->getOption('hide_results')) {
            $oQuiz->setHideResults($sHideResults);
        }
        // Defaults to false, we want this default to true
        $oQuiz->setShuffleAnswers((bool)$input->getOption('shuffle_answers'));
        $output->write("Creating new Quiz <info>{$oQuiz->getTitle()}</info> in a course <comment>{$iCourseId}</comment> ");
        $aCreatedQuiz = $oCanvas->createQuiz($iCourseId, $oQuiz);

        $table = new Table($output);
        $table->setHeaders(['Key', 'Value']);

        foreach ($aCreatedQuiz as $key => $value) {
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