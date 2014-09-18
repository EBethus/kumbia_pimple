<?php

use Kumbia\Application\Application;
use Kumbia\Debugbar\DebugbarServiceProvider;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

Debug::enable();

$app = new Application($loader, __DIR__ . '/../app/', true);

$app->register(new DebugbarServiceProvider());

$app->run(Request::createFromGlobals())->send();