<?php

namespace Security\Authenticator;

use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

abstract class AbstractAuthenticator extends AbstractGuardAuthenticator
{
    const HTTP_HEADER = 'X-Access-Token';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        MetaService::addMessage(strtr($exception->getMessageKey(), $exception->getMessageData()));

        return AbstractController::jsonResponse(array(), MetaService::getMessages(), 401);
    }

    /**
     * Called when authentication is needed, but it's not sent.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException|null $authException
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return $this->failAuthentication();
    }

    /**
     * Stateless does not support remember me.
     *
     * @return bool
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function failAuthentication()
    {
        MetaService::addMessage('Authentication Required');

        return AbstractController::jsonResponse(array(), MetaService::getMessages(), 401);
    }
}
