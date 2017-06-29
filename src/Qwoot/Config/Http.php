<?php

namespace Qwoot\Config;

use Doctrine\DBAL\DBALException;
use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Security\Authenticator\AbstractAuthenticator;
use Security\Http\SecurityResponse;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class Http
{
    /**
     * Apply Middleware to a HTTP Request.
     *
     * @param \Silex\Application $app
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function setUp(Application $app)
    {
        $app->before(function (Request $request) use ($app) {
            // Catch OPTIONS requests and indicate headers for CORS, this only works in Silex debug mode.
            if ($app['debug'] && Request::METHOD_OPTIONS === $request->getMethod()) {
                $response = new Response();
                $response->setStatusCode(Response::HTTP_OK);

                $response->headers->add($this->getCorsHeaders($request));

                return $response;
            }

            // Make sure to accept JSON requests.
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }

            return null;
        }, Application::EARLY_EVENT);

        $app->after(function (Request $request, Response $response) use ($app) {
            // Make sure a 'SecurityResponse' gets translated to the correct format.
            if ($response instanceof SecurityResponse) {
                $response = AbstractController::jsonResponse(json_decode($response->getContent(), true), array());
            }

            if ($app['debug']) {
                // If app in debug mode, send CORS headers.
                $response->headers->add($this->getCorsHeaders($request));
            }

            return $response;
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

                    error_log(get_class($e) . '; ' . $message . '; ' . $e->getTraceAsString());
                }

                if ($e instanceof AuthenticationCredentialsNotFoundException) {
                    $code = Response::HTTP_UNAUTHORIZED;
                }

                if ($e instanceof InvalidArgumentException) {
                    $code = Response::HTTP_BAD_REQUEST;
                }

                MetaService::addMessage($message);
            }

            return AbstractController::jsonResponse(array(), MetaService::getMessages(), $code);
        }, 256);

        return null;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    private function getCorsHeaders(Request $request)
    {
        return array(
            'Access-Control-Allow-Origin' => $request->headers->get('origin'),
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers' => AbstractAuthenticator::DEFAULT_HEADER_TOKEN . ', content-type',
        );
    }
}
