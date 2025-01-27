<?php
// application.php

require dirname(__DIR__, 1) . '/vendor/autoload.php';

use Hurah\Types\Type\Path;
use Symfony\Component\Console\Application;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();
