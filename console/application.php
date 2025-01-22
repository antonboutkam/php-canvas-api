#!/usr/bin/env php
<?php
// application.php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Hurah\Types\Type\Path;
use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$application = new Application();

$oDir = Path::make(__DIR__)->dirname(1)->extend('src', 'commands');
$oFinder = $oDir->getFinder()->name('*Command.php');

foreach ($oFinder as $oFile) {
    if(str_ends_with('Trait', $oFile->getBasename('.php')))
    {
        continue;
    }
    $sClassName = 'Hurah\\Canvas\\Commands\\' . $oFile->getBasename('.php');
    $application->add(new $sClassName());
}

$application->run();