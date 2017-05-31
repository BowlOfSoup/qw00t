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
        $this->addRoute('/quotes', QuoteController::ID . ':getListAction');

        return $this->controllers;
    }

    /**
     * @param string $route
     * @param string $entryPoint
     * @param bool $secure
     */
    private function addRoute($route, $entryPoint, $secure = false)
    {
        $this->controllers->get($route, $entryPoint);
        if ($secure) {
            $this->app[SecurityProvider::ID]->makeSecure($route);
        }
    }
}