<?php

namespace Security\Authenticator;

use Security\Encoder\JwtTokenEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtTokenAuthenticator extends AbstractAuthenticator
{
    /** @var \Security\Encoder\JwtTokenEncoder */
    private $jwtTokenEncoder;

    /** @var string */
    private $authorizationHeader;

    /**
     * @param \Security\Encoder\JwtTokenEncoder $jwtTokenEncoder
     * @param string $authorizationHeader
     */
    public function __construct(
        JwtTokenEncoder $jwtTokenEncoder,
        $authorizationHeader
    ) {
        $this->jwtTokenEncoder = $jwtTokenEncoder;
        $this->authorizationHeader = $authorizationHeader;
    }

    /**
     * Get the authentication credentials from the request.
     *
     * Whatever value you return here will be passed to getUser() and checkCredentials().
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return object|null
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get($this->authorizationHeader)) {
            return null;
        }

        return $this->jwtTokenEncoder->decode($token);
    }

    /**
     * Return a UserInterface object based on the credentials.
     *
     * The $token is the return value from getCredentials().
     *
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
