<?php

namespace Security\Encoder;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class PasswordEncoder
{
    /** @var \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface */
    private $passwordEncoder;

    /** @var string */
    private $passwordSalt;

    /** @var string */
    private $passwordStrengthRegex;

    /** @var string */
    private $passwordStrengthError;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface $passwordEncoder
     * @param mixed $passwordSalt
     * @param string $passwordStrengthRegex
     * @param string $passwordStrengthError
     */
    public function __construct(
        PasswordEncoderInterface $passwordEncoder,
        $passwordSalt,
        $passwordStrengthRegex,
        $passwordStrengthError
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->passwordSalt = $passwordSalt;
        $this->passwordStrengthRegex = $passwordStrengthRegex;
        $this->passwordStrengthError = $passwordStrengthError;
    }

    /**
     * Validate password, does it match the regex provided?
     *
     * @param string $rawPassword
     *
     * @throws
     *
     * @return bool
     */
    public function validatePassword($rawPassword)
    {
        preg_match($this->passwordStrengthRegex, $rawPassword, $matches);
        if (!empty($matches)) {
            return true;
        }

        throw new InvalidArgumentException($this->passwordStrengthError);
    }

    /**
     * Encode a raw password.
     *
     * @param string $rawPassword
     *
     * @return string
     */
    public function encodePassword($rawPassword)
    {
        return $this->passwordEncoder->encodePassword($rawPassword, $this->passwordSalt);
    }
}
