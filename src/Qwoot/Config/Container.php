<?php

namespace Qwoot\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Qwoot\Controller\QuoteController;
use Qwoot\FormType\QuoteFormType;
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

        $this->controllerServices();
        $this->formTypeServices();
        $this->serviceServices();
        $this->repositoryServices();
    }

    /**
     * Register services for the \Qwoot\Controller namespace.
     */
    private function controllerServices()
    {
        $this->container[QuoteController::ID] = function (Application $app) {
            return new QuoteController(
                $app[QuoteService::ID],
                $app['qwoot.form_type.quote_form_type']
            );
        };
    }

    /**
     * Register services for the \Qwoot\FormType namespace.
     */
    private function formTypeServices()
    {
        $this->container[QuoteFormType::ID] = function (Application $app) {
            return new QuoteFormType(
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
