<?php

namespace Qwoot\Config;

use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Http
{
    /**
     * Apply Middleware to a HTTP Request.
     *
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        // Make sure to accept JSON requests.
        $app->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });

        // If route is part of API, do not send pretty responses.
        $app->error(function (\Exception $e, Request $request, $code) use ($app) {
            if (false === strpos($request->getRequestUri(), 'api/')) {
                return null;
            }

            if (!$app['debug']) {
                MetaService::addMessage('We are sorry, but something went terribly wrong.');
            } else {
                MetaService::addMessage($e->getMessage());

                error_log($e->getMessage() . ' ' . $e->getTraceAsString());
            }

            return AbstractController::jsonResponse(array(), MetaService::getMessages(), $code);
        }, 256);
    }
}
