<?php

namespace Qwoot\Config;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Http
{
    const ID = 'qwoot.config.http';

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

        $app->after(function (Request $request, Response $response) {
            $response->headers->set('Content-Type', 'application/json');
        });
    }
}
