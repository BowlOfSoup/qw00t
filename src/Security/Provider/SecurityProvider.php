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
            'token_life_time' => 86400,
            'algorithm' => 'HS256',
            'options' => array(
                'header_name' => 'X-Access-Token',
            ),
        ), $app['security.defaults']);
    }
}
