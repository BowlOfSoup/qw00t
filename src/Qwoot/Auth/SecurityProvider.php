<?php

namespace Qwoot\Auth;

use Qwoot\Config\Routes;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class SecurityProvider
{
    const ID = 'qwoot.auth.security_provider';
    const TOKEN_HEADER_KEY = 'X-Token';
    const TOKEN_SESSION_KEY = 'token';

    /** @var \Symfony\Component\HttpFoundation\Session\Session */
    private $session;

    /** @var array */
    private $securedRoutes = array();

    /**
     * @param \Symfony\Component\HttpFoundation\Session\Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        $app->before(function (Request $request, Application $app) {
            $app[static::ID]->checkAccess($request);
        });
    }

    /**
     * @param string $route
     */
    public function makeSecure($route)
    {
        preg_match('/{(.*?)\}/s', $route, $matches);
        $this->securedRoutes[] = Routes::PREFIX . str_replace('{' . $matches[1] . '}', '#', $route);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     *
     * @return true
     */
    public function checkAccess(Request $request)
    {
        if (!$this->isPathSecure($request->getPathInfo())) {
            return true;
        }

        $sentToken = $request->headers->get(static::TOKEN_HEADER_KEY);
//        bin2hex(openssl_random_pseudo_bytes(16));
//        if (empty($sentToken) || $this->session->get(static::TOKEN_SESSION_KEY) !== $sentToken) {
        if ('asd' !== $sentToken) {
            throw new AccessDeniedHttpException('Access Denied');
        }

        return true;
    }

    /**
     * @param string $route
     *
     * @return bool
     */
    private function isPathSecure($route)
    {
        preg_match_all('/\d+/', $route, $matches);
        foreach ($matches as $match) {
            $route = str_replace($match[0], '#', $route);
        }

        return in_array($route, $this->securedRoutes);
    }
}
