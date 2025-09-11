<?php

namespace Hurah\Canvas\Commands;


use Hurah\Canvas\Canvas;
use Hurah\Canvas\Endpoints\Folder\Folder;
use Hurah\Types\Exception\InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FolderCreateCommand extends Command
{
    function configure(): void
    {
        $this->setDescription('Folder create command');
        $this->setHelp('Creates a new folder in a project');
        $this->setName('folder:create');

        $this->addArgument('course_id', InputArgument::REQUIRED, 'The canvas id of the course');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the folder to be created');

        $this->addOption('parent-folder-id', 'i', InputOption::VALUE_OPTIONAL, 'The id of the parent directory (optional, do not mix with parent-folder-path)');
        $this->addOption('parent-folder-path', 'p', InputOption::VALUE_OPTIONAL, 'The id of the parent directory (optional, do not mix with parent-folder-id)');
        $this->addOption('locked', 'l', InputOption::VALUE_OPTIONAL, 'Flag the folder as locked 1 = true, 0 = false',
            '0');
        $this->addOption('hidden', 'd', InputOption::VALUE_OPTIONAL, 'Flag the folder as hidden 1 = true, 0 = false',
            '0');
        $this->addOption('position', 's', InputOption::VALUE_OPTIONAL, 'Position');

    }

    /**
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Arguments
        $courseId = $input->getArgument('course_id');
        $name = $input->getArgument('name');

        // Options
        $parentFolderId = $input->getOption('parent-folder-id');
        $parentFolderPath = $input->getOption('parent-folder-path');
        $locked = $input->getOption('locked');
        $hidden = $input->getOption('hidden');
        $position = $input->getOption('position');

        $oCanvas = new Canvas();
        $oFolder = new Folder();

        $aData  = [
            'name' => $name
        ];
        if ($parentFolderId) {
            $aData['parent_folder_id'] = $parentFolderId;
        }
        elseif ($parentFolderPath) {
            $aData['parent_folder_path'] = $parentFolderId;
        }

        if((int)$locked ===  1)
        {
            $aData['locked'] = $locked;
        }
        if((int)$hidden ===  1)
        {
            $aData['hidden'] = $hidden;
        }
        if($position)
        {
            $aData['position'] = $position;
        }

        $output->writeln('Creating folder');
        $output->writeln(print_r($aData, true));
        $oCanvas->createFolder($courseId, $aData);

        // hier kun je die variabelen gebruiken
        // bv: $oFolder->setName($name);

        return Command::SUCCESS;
    }

}