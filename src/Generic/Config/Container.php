<?php

namespace Generic\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
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
    }

    /**
     * Register services for the \Qwoot\Config namespace.
     *
     * @param \Pimple\Container $container
     */
    private function configServices(PimpleContainer $container)
    {
        $container['generic.config.database'] = function (Application $app) {
            return new Database();
        };
    }
}
