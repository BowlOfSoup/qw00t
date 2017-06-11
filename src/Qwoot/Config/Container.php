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
        // Config services.
        $container['qwoot.config.security'] = function (Application $app) {
            return new Security();
        };
        $container['qwoot.config.http'] = function (Application $app) {
            return new Http();
        };

        // Controller services.
        $container['qwoot.controller.quote_controller'] = function (Application $app) {
            return new QuoteController(
                $app['qwoot.service.quote_service'],
                $app['qwoot.form_type.quote_form_type'],
                $app['security.service.user_service']
            );
        };

        // FormType services.
        $container['qwoot.form_type.quote_form_type'] = function (Application $app) {
            return new QuoteFormType(
                $app['form.factory']
            );
        };

        // Service services.
        $container['qwoot.service.quote_service'] = function (Application $app) {
            return new QuoteService(
                $app['qwoot.repository.quote_repository']
            );
        };

        // Repository services.
        $container['qwoot.repository.quote_repository'] = function (Application $app) {
            return new QuoteRepository(
                $app['db']
            );
        };
    }
}
