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

        $this->configServices();
        $this->controllerServices();
        $this->formTypeServices();
        $this->serviceServices();
        $this->repositoryServices();
    }

    /**
     * Register services for the \Security\Config namespace.
     */
    private function configServices()
    {
        $this->container['qwoot.config.security'] = function (Application $app) {
            return new Security();
        };

        $this->container['qwoot.config.http'] = function (Application $app) {
            return new Http();
        };
    }

    /**
     * Register services for the \Qwoot\Controller namespace.
     */
    private function controllerServices()
    {
        $this->container['qwoot.controller.quote_controller'] = function (Application $app) {
            return new QuoteController(
                $app['qwoot.service.quote_service'],
                $app['qwoot.form_type.quote_form_type']
            );
        };
    }

    /**
     * Register services for the \Qwoot\FormType namespace.
     */
    private function formTypeServices()
    {
        $this->container['qwoot.form_type.quote_form_type'] = function (Application $app) {
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
        $this->container['qwoot.service.quote_service'] = function (Application $app) {
            return new QuoteService(
                $app['qwoot.repository.quote_repository']
            );
        };
    }

    /**
     * Register services for the \Qwoot\Repository namespace.
     */
    private function repositoryServices()
    {
        $this->container['qwoot.repository.quote_repository'] = function (Application $app) {
            return new QuoteRepository(
                $app['db']
            );
        };
    }
}
