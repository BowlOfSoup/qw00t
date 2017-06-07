<?php

namespace Security\Encoder;

use Firebase\JWT\JWT;

class JwtTokenEncoder
{
    const EXPIRE_PROPERTY = 'exp';
    const TOKEN_SEPARATOR = '.';

    /**
     * Time in seconds during which the token is valid.
     *
     * @var int
     */
    private $tokenLifeTime;

    /**
     * Secret key which is used to sign.
     *
     * @var string
     */
    private $secretKey;

    /**
     * Allowed algorithms for signing the token.
     *
     * @var array
     */
    private $algorithm = array();

    /**
     * @param int $tokenLifeTime
     * @param string $secretKey
     * @param string $algorithm
     */
    public function __construct($tokenLifeTime, $secretKey, $algorithm)
    {
        $this->tokenLifeTime = $tokenLifeTime;
        $this->secretKey = $secretKey;
        $this->algorithm = $algorithm;
    }

    /**
     * Encode data into a token.
     *
     * @param mixed $data
     *
     * @return string
     */
    public function encode($data)
    {
        $data[static::EXPIRE_PROPERTY] = time() + $this->tokenLifeTime;

        return JWT::encode($data, $this->secretKey, $this->algorithm);
    }

    /**
     * Decode a token into data.
     *
     * @param string $token
     *
     * @return mixed
     */
    public function decode($token)
    {
        // Check for valid token syntax.
        if (false === strpos($token, static::TOKEN_SEPARATOR)) {
            return null;
        }

        try {
            return JWT::decode($token, $this->secretKey, $this->algorithm);
        } catch (\UnexpectedValueException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        } catch (\DomainException $e) {
            throw new \UnexpectedValueException($e->getMessage());
        }
    }
}
