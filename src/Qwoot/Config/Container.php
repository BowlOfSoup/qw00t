<?php

namespace Qwoot\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Qwoot\Auth\SecurityProvider;
use Qwoot\Controller\QuotesController;
use Qwoot\Service\QuoteService;
use Silex\Application;

class Container implements ServiceProviderInterface
{
    /** @var \Pimple\Container */
    private $container;

    /**
     * Register services in the application container.
     *
     * @param \Pimple\Container $container
     */
    public function register(PimpleContainer $container)
    {
        $this->container = $container;

        $this->authServices();
        $this->configServices();
        $this->controllerServices();
        $this->serviceServices();
    }

    /**
     * Register services for the \Qwoot\Auth namespace.
     */
    private function authServices()
    {
        $this->container[SecurityProvider::ID] = function (Application $app) {
            return new SecurityProvider(
                $app['session']
            );
        };
    }

    /**
     * Register services for the \Qwoot\Config namespace.
     */
    private function configServices()
    {
        $this->container[Http::ID] = function (Application $app) {
            return new Http();
        };

        $this->container[Database::ID] = function (Application $app) {
            return new Database();
        };
    }

    /**
     * Register services for the \Qwoot\Controller namespace.
     */
    private function controllerServices()
    {
        $this->container[QuotesController::ID] = function (Application $app) {
            return new QuotesController(
                $app[QuoteService::ID]
            );
        };
    }

    /**
     * Register services for the \Qwoot\Service namespace.
     */
    private function serviceServices()
    {
        $this->container[QuoteService::ID] = function (Application $app) {
            return new QuoteService(
                $app['db']
            );
        };
    }
}
