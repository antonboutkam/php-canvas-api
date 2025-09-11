<?php

namespace Hurah\Canvas\Commands;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Hurah\Canvas\Canvas;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Url;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FileCreateFromUrlCommand extends Command
{
    function configure(): void
    {
        $this->setDescription('Create a file by specifying a url');
        $this->setHelp('Use course:list to get the id of the folder, choose a path to create the directory in or update.');
        $this->setName('file:create:url');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The id of the course to store the file in');
        $this->addArgument('folder_path', InputArgument::REQUIRED, 'The path of the folder to store the new folder in. The path separator is the forward slash ‘/`, never a back slash. The parent folder will be created if it does not already exist. This parameter only applies to new folders in a context that has folders, such as a user, a course, or a group. If this and parent_folder_id are sent an error will be returned. If neither is given, a default folder will be used.');
        $this->addArgument('url', InputArgument::REQUIRED, 'The url to the file');
        $this->addOption('file_name', 'f', InputOption::VALUE_OPTIONAL, 'The file name to use as original file, if not specified the basename is picked from the url.');
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $iCourseId = $input->getArgument('course_id');
        $sFolderPath = $input->getArgument('folder_path');
        $sUrl = $input->getArgument('url');
        $sFileName = $input->getOption('file_name');

        $oUrl = new Url($sUrl);
        if(!$sFileName)
        {
            $sFileName = $oUrl->basename();
        }


        $client = new Client();

        try {
            // Send a HEAD request (only fetches headers, not body)
            $response = $client->head($sUrl);

            // Get the Content-Type header
            $sContentType = $response->getHeaderLine('Content-Type');
            $sContentSize = $response->getHeaderLine('Content-Length');

            $output->writeln('<comment>Content type</comment>: ' . $sContentType);
            $output->writeln('<comment>Content length</comment>: ' . $sContentSize);

        } catch (RequestException $e) {
            $output->writeln("<error>" . $e->getMessage() . '</error>');
            $output->writeln("<error>" . $e->getFile() . '::' . $e->getLine() . '</error>');
        }

        $oCanvas = new Canvas();
        $oFile = $oCanvas->uploadFileFromUrl($iCourseId, $sFileName, $sFolderPath, $sContentType, $sUrl, $sContentSize);

        $iCourseId = $input->getArgument('course_id');

        $oFileCollection = $oCanvas->getFiles($iCourseId);

        $table = new Table($output);
        $table->setHeaders(['File id', 'Display name', 'Content type', 'Url']);

        foreach ($oFileCollection as $oSubmission) {
            $table->addRow([
                $oFile->getId(),
                $oFile->getDisplayName(),
                $oFile->getContentType(),
                $oFile->getUrl()
            ]);
        }


        $table->render();

        return Command::SUCCESS;
    }
}