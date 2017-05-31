<?php

namespace Qwoot\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Qwoot\Auth\SecurityProvider;
use Qwoot\Controller\QuoteController;
use Qwoot\Repository\QuoteRepository;
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
        $this->repositoryServices();
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
        $this->container[QuoteController::ID] = function (Application $app) {
            return new QuoteController(
                $app[QuoteService::ID],
                $app['form.factory']
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
                $app[QuoteRepository::ID]
            );
        };
    }

    /**
     * Register services for the \Qwoot\Repository namespace.
     */
    private function repositoryServices()
    {
        $this->container[QuoteRepository::ID] = function (Application $app) {
            return new QuoteRepository(
                $app['db']
            );
        };
    }
}
