<?php

use Generic\Config\Container as GenericContainer;
use Generic\Config\Database as Database;
use Generic\Config\Http as GenericHttp;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Qwoot\Config\Container as QwootContainer;
use Qwoot\Config\Routes as QwootRoutes;
use Security\Config\Container as SecurityContainer;
use Security\Provider\SecurityProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Application();
$app['debug'] = true;

# Register containers
## Third party
$app->register(new ServiceControllerServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new FormServiceProvider());
## Components
$app->register(new GenericContainer());
$app->register(new QwootContainer());
$app->register(new SecurityContainer());

# Register routes
$app->mount(QwootRoutes::PREFIX, new QwootRoutes());

# Database connection.
$app[Database::ID]->setUp($app);

# Make app accept JSON API requests.
$app[GenericHttp::ID]->setUp($app);

# Security check.
$app[SecurityProvider::ID]->setUp($app);

$app->run();
