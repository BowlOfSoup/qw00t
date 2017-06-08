<?php

namespace Security\Authenticator;

use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

abstract class AbstractAuthenticator extends AbstractGuardAuthenticator
{
    const HTTP_HEADER = 'X-Access-Token';

    /**
     * Returns true if the credentials are valid.
     *
     * $credentials is the return value from getCredentials().
     *
     * @param mixed $credentials
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @throws AuthenticationException
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * Called when authentication executed and was successful.
     *
     * This should return the Response sent back to the user.
     * If you return null, the current request will continue, and the user will be authenticated.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return null;
    }

    /**
     * Called when authentication executed, but failed (e.g. wrong username password).
     *
     * This should return the Response sent back to the user, like a RedirectResponse to a login page or a 403 response.
     *
     * If you return null, the request will continue.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Exception\AuthenticationException $exception
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        MetaService::addMessage(strtr($exception->getMessageKey(), $exception->getMessageData()));

        return AbstractController::jsonResponse(array(), MetaService::getMessages(), Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns a response that directs the user to authenticate, when authentication is needed, but it's not sent.
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
     * {@inheritDoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }

    /**
     * Returns a response which indicates that authentication is (still) required.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function failAuthentication()
    {
        MetaService::addMessage('Authentication Required');

        return AbstractController::jsonResponse(array(), MetaService::getMessages(), Response::HTTP_UNAUTHORIZED);
    }
}
