<?php

namespace Security\Authenticator;

use Security\Encoder\JwtTokenEncoder;
use Security\Http\SecurityResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class PasswordAuthenticatorReturnJwtToken extends PasswordAuthenticator
{
    /** @var \Security\Encoder\JwtTokenEncoder */
    private $jwtEncoder;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface $encoderFactory
     * @param \Security\Encoder\JwtTokenEncoder $jwtTokenEncoder
     * @param string $passwordSalt
     * @param string $authorizationHeader
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        JwtTokenEncoder $jwtTokenEncoder,
        $passwordSalt,
        $authorizationHeader
    ) {
        parent::__construct($encoderFactory, $passwordSalt, $authorizationHeader);

        $this->jwtEncoder = $jwtTokenEncoder;
    }

    /**
     * Called when authentication executed and was successful.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @param string $providerKey
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        /** @var \Symfony\Component\Security\Core\User\UserInterface $user */
        $user = $token->getUser();

        $jwtToken = $this->jwtEncoder->encode(
            array(
                'username' => $user->getUsername(),
                'roles' => json_encode($user->getRoles()),
            )
        );

        return new SecurityResponse(
            array(
                'username' => $user->getUsername(),
                'token' => $jwtToken,
            )
        );
    }
}
