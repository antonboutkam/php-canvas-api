#!/usr/bin/env php
<?php
// application.php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Hurah\Types\Type\Path;
use Symfony\Component\Console\Application;

$sEnvFile = dirname(__DIR__, 1);
if(file_exists($sEnvFile))
{
	// $_ENV variables may be defined in another way
	$dotenv = Dotenv\Dotenv::createImmutable($sEnvFile);
	$dotenv->load();
}
$application = new Application();

$oDir = Path::make(__DIR__)->dirname(1)->extend('src', 'commands');
$oFinder = $oDir->getFinder()->name('*Command.php');

foreach ($oFinder as $oFile) {
    // echo 'Autoload: ' . $oFile->getBasename('.php') . PHP_EOL;
    if(str_ends_with($oFile->getBasename('.php'), 'Trait'))
    {
        continue;
    }
    $sClassName = 'Hurah\\Canvas\\Commands\\' . $oFile->getBasename('.php');
    $application->add(new $sClassName());
}

$application->run();
