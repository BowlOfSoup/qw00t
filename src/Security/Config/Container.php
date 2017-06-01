<?php

namespace Security\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Security\Provider\SecurityProvider;
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

        $this->providerServices();
    }

    /**
     * Register services for the \Security\Provider namespace.
     */
    private function providerServices()
    {
        $this->container[SecurityProvider::ID] = function (Application $app) {
            return new SecurityProvider(
                $app['session']
            );
        };
    }
}
