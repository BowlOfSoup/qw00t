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
    /**
     * Register services in the application container.
     *
     * @param \Pimple\Container $container
     */
    public function register(PimpleContainer $container)
    {
        $this->configServices($container);
        $this->controllerServices($container);
        $this->formTypeServices($container);
        $this->serviceServices($container);
        $this->repositoryServices($container);
    }

    /**
     * Register services for the \Security\Config namespace.
     *
     * @param \Pimple\Container $container
     */
    private function configServices(PimpleContainer $container)
    {
        $container['qwoot.config.security'] = function (Application $app) {
            return new Security();
        };

        $container['qwoot.config.http'] = function (Application $app) {
            return new Http();
        };
    }

    /**
     * Register services for the \Qwoot\Controller namespace.
     *
     * @param \Pimple\Container $container
     */
    private function controllerServices(PimpleContainer $container)
    {
        $container['qwoot.controller.quote_controller'] = function (Application $app) {
            return new QuoteController(
                $app['qwoot.service.quote_service'],
                $app['qwoot.form_type.quote_form_type']
            );
        };
    }

    /**
     * Register services for the \Qwoot\FormType namespace.
     *
     * @param \Pimple\Container $container
     */
    private function formTypeServices(PimpleContainer $container)
    {
        $container['qwoot.form_type.quote_form_type'] = function (Application $app) {
            return new QuoteFormType(
                $app['form.factory']
            );
        };
    }

    /**
     * Register services for the \Qwoot\Service namespace.
     *
     * @param \Pimple\Container $container
     */
    private function serviceServices(PimpleContainer $container)
    {
        $container['qwoot.service.quote_service'] = function (Application $app) {
            return new QuoteService(
                $app['qwoot.repository.quote_repository']
            );
        };
    }

    /**
     * Register services for the \Qwoot\Repository namespace.
     *
     * @param \Pimple\Container $container
     */
    private function repositoryServices(PimpleContainer $container)
    {
        $container['qwoot.repository.quote_repository'] = function (Application $app) {
            return new QuoteRepository(
                $app['db']
            );
        };
    }
}
