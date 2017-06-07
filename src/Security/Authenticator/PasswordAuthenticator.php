<?php

namespace Security\Authenticator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class PasswordAuthenticator extends AbstractAuthenticator
{
    const HEADER_SEPARATOR = ':';
    const PROPERTY_USERNAME = 'username';
    const PROPERTY_SECRET = 'secret';

    /** @var \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface */
    protected $encoderFactory;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|null
     */
    public function getCredentials(Request $request)
    {
        if (!$token = $request->headers->get(static::HTTP_HEADER)) {
            return null;
        }

        // Header must contain username:password
        if (false === strpos($token, static::HEADER_SEPARATOR)) {
            return null;
        }
        list($username, $secret) = explode(static::HEADER_SEPARATOR, $token, 2);

        return array(
            static::PROPERTY_USERNAME => $username,
            static::PROPERTY_SECRET => $secret,
        );
    }

    /**
     * @param array $credentials
     * @param \Symfony\Component\Security\Core\User\UserProviderInterface $userProvider
     *
     * @return \Symfony\Component\Security\Core\User\UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        return $userProvider->loadUserByUsername($credentials[static::PROPERTY_USERNAME]);
    }

    /**
     * @param array $credentials
     * @param \Symfony\Component\Security\Core\User\UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        $encoder = $this->encoderFactory->getEncoder($user);

        return $encoder->isPasswordValid(
            $user->getPassword(),
            $credentials[static::PROPERTY_SECRET],
            getenv('AUTHENTICATION_SECRET')
        );
    }
}
