<?php

use Generic\Config\Container as GenericContainer;
use Qwoot\Config\Container as QwootContainer;
use Qwoot\Config\Routes as QwootRoutes;
use Security\Config\Container as SecurityContainer;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$dotEnv = new Dotenv\Dotenv(__DIR__);
$dotEnv->load();

$app = new Application();
$app['debug'] = getenv('SILEX_DEBUG');

// Register containers, third party
$app->register(new ServiceControllerServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new FormServiceProvider());

/// Register containers, components
$app->register(new GenericContainer());
$app->register(new QwootContainer());
$app->register(new SecurityContainer());

// Register routes
$app->mount('/api', new QwootRoutes());

// Database connection.
$app['generic.config.database']->setUp($app);

// Set http request and response handlers.
$app['qwoot.config.http']->setUp($app);

// Initialize security.
$app['qwoot.config.security']->setUp($app);

$app->run();
