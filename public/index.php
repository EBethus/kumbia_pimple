<?php

use Kumbia\Application\Application;
use Kumbia\Debugbar\DebugbarServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

Debug::enable();

define('APP_CHARSET', 'utf-8');
define('APP_PATH', realpath(__DIR__ . '/../app') . '/');
define('START_TIME', microtime(TRUE));

function kumbia_version() { return 'TEST 1.0'; }

$app = new Application(APP_PATH, true);

$app->register(new DebugbarServiceProvider());

$app->run(Request::createFromGlobals())->send();