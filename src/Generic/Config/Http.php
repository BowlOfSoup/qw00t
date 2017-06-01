<?php

namespace Generic\Config;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Http
{
    const ID = 'generic.config.http';

    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });
    }
}
