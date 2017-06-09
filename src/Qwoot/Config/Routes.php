<?php

namespace Qwoot\Config;

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

        $controllers->post('/login');
        $controllers->post('/user', 'security.controller.user_controller' . ':createAction');

        $controllers->get('/quotes', 'qwoot.controller.quote_controller' . ':getListAction');
        $controllers->post('/quotes', 'qwoot.controller.quote_controller' . ':createAction');

        return $controllers;
    }
}
