<?php

namespace Qwoot\Config;

use Qwoot\Auth\SecurityProvider;
use Qwoot\Controller\QuoteController;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class Routes implements ControllerProviderInterface
{
    const PREFIX = '/api';
    const SECURE_ROUTE = true;

    /** @var \Silex\ControllerCollection */
    private $controllers;

    /** @var \Silex\Application */
    private $app;

    /**
     * Add routes within this method.
     *
     * @param \Silex\Application $app
     *
     * @return \Silex\Application
     */
    public function connect(Application $app)
    {
        $this->app = $app;
        $this->controllers = $this->app['controllers_factory'];

        # Add routes here.
        $this->controllers->get('/quotes', QuoteController::ID . ':getListAction');
        $this->controllers->post('/quotes', QuoteController::ID . ':createAction');

        return $this->controllers;
    }

    /**
     * @param string $route
     *
     * @return string
     */
    private function secureRoute($route)
    {
        $this->app[SecurityProvider::ID]->makeSecure($route);

        return $route;
    }
}