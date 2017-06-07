<?php

namespace Qwoot\Config;

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

        $controllers->get('/quotes', 'qwoot.controller.quote_controller' . ':getListAction');
        $controllers->post('/quotes', 'qwoot.controller.quote_controller' . ':createAction');

        return $controllers;
    }
}
