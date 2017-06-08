<?php

namespace Security\Config;

use Silex\Api\ControllerProviderInterface;
use Silex\Application;

class Routes implements ControllerProviderInterface
{
    /**
     * Add routes within this method.
     *
     * @param \Silex\Application $app
     *
     * @return \Silex\ControllerCollection
     */
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        return $controllers;
    }
}
