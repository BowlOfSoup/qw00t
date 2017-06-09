<?php

namespace Qwoot\Config;

use Doctrine\DBAL\DBALException;
use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

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

            if (false !== strpos($request->getRequestUri(), 'api/')) {
                $message = 'We are sorry, but something went terribly wrong.';

                if ($app['debug']) {
                    $message = $e->getMessage();

                    if ($e instanceof DBALException) {
                        $message = MetaService::MESSAGE_DATABASE;
                    }

                    error_log($message . ' ' . $e->getTraceAsString());
                }

                if ($e instanceof InvalidArgumentException) {
                    $code = Response::HTTP_BAD_REQUEST;
                }

                MetaService::addMessage($message);
            }

            return AbstractController::jsonResponse(array(), MetaService::getMessages(), $code);
        }, 256);
    }
}
