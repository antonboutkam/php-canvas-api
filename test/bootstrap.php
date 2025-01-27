<?php
// application.php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Hurah\Types\Type\Path;
use Symfony\Component\Console\Application;

if(file_exists(dirname(__DIR__, 1) . '.env')) {
	// $_ENV variables may be defined in another way
	$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
	$dotenv->load();
}
