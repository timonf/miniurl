<?php

declare(strict_types=1);

use MiniUrl\App;
use Symfony\Component\HttpFoundation\Request;

if (PHP_VERSION_ID < 80000) {
    echo 'Error 1: This project requires PHP 8.0 or higher.' . PHP_EOL;
    exit(1);
}

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    echo 'Error 2: Please run "composer install" first.' . PHP_EOL;
    exit(2);
}

if (!file_exists(__DIR__ . '/../config.php')) {
    echo 'Error 3: Please create a config.php file (use config.example.php as base).' . PHP_EOL;
    exit(3);
}

try {
    require_once __DIR__ . '/../vendor/autoload.php';

    $request = Request::createFromGlobals();
    $app = App::createFromResolverList(include __DIR__ . '/../config.php');
    $app->run($request)->send();
} catch (Throwable $exception) {
    http_response_code(500);
    echo $exception->getMessage() . PHP_EOL;
    exit($exception->getCode());
}
