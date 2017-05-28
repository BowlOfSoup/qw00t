<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Qwoot\Auth\SecurityProvider;
use Qwoot\Config\Container as QwootContainer;
use Qwoot\Config\Database;
use Qwoot\Config\Http;
use Qwoot\Config\Routes as QwootRoutes;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

# Register containers
$app->register(new ServiceControllerServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new QwootContainer());

# Register routes
$app->mount(QwootRoutes::PREFIX, new QwootRoutes());

# Database connection.
$app[Database::ID]->setUp($app);

# Make app accept JSON API requests.
$app[Http::ID]->setUp($app);

# Security check.
$app[SecurityProvider::ID]->setUp($app);

$app->run();
