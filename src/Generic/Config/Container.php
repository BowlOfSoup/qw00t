<?php

namespace Generic\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
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
    }

    /**
     * Register services for the \Qwoot\Config namespace.
     */
    private function configServices()
    {
        $this->container['generic.config.http'] = function (Application $app) {
            return new Http();
        };

        $this->container['generic.config.database'] = function (Application $app) {
            return new Database();
        };
    }
}
