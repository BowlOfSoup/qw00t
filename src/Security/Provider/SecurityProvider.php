<?php

namespace Security\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Security\Core\Exception\InvalidArgumentException;

class SecurityProvider implements ServiceProviderInterface
{
    /**
     * Registers defaults security parameters.
     *
     * Can and should be overwritten in the 'global' security initialization.
     *
     * @param \Pimple\Container|array $app
     */
    public function register(Container $app)
    {
        if (!$app->offsetExists('security.defaults') || empty($app['security.defaults'])) {
            $error = 'You have to at least set [\'security.defaults\'][\'secret_key\'] in the Silex container.';
            echo $error;

            throw new InvalidArgumentException($error);
        }

        $app['security.defaults'] = array_replace_recursive(array(
            'secret_key' => 'default_secure_key_please_overwrite_this_value',
            'password_strength_regex' => '((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{10,})',
            'token_life_time' => 86400,
            'token_algorithm' => 'HS256',
            'authorization_header' => 'X-Access-Token',
            'messages' => array(
                'username_or_email_already_in_use_error' => '\'%s\' is already in use.',
                'password_strength_error' => 'Invalid password: must contain at least 10 characters with lower/uppercase letters, numbers and special characters.',
            )
        ), $app['security.defaults']);
    }
}
