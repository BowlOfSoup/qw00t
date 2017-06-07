<?php

namespace Security\Authenticator;

use Firebase\JWT\JWT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtAuthenticator extends AbstractAuthenticator
{
    const JWT_TOKEN_SEPARATOR = '.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return object|null
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get(static::HTTP_HEADER)) {
            return null;
        }

        // Header must contain JWT token.
        if (false === strpos($token, static::JWT_TOKEN_SEPARATOR)) {
            return null;
        }

        try {
            return JWT::decode($token, getenv('AUTHENTICATION_SECRET'), array('HS256'));
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        } catch (\DomainException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        }
    }

    /**
     * @param object $token
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser($token, UserProviderInterface $userProvider)
    {
        return new User($token->username, null, json_decode($token->roles));
    }
}
