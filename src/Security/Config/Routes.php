<?php

namespace Security\Config;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

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

        $controllers->post('/login');

        return $controllers;
    }
}
