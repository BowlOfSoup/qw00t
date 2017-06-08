<?php

namespace Security\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Security\Authenticator\JwtAuthenticator;
use Security\Authenticator\PasswordAuthenticator;
use Security\Authenticator\PasswordAuthenticatorReturnJwtToken;
use Security\Encoder\JwtTokenEncoder;
use Security\Provider\UserProvider;
use Silex\Application;

class Container implements ServiceProviderInterface
{
    /**
     * Register services in the application container.
     *
     * @param \Pimple\Container $container
     */
    public function register(PimpleContainer $container)
    {
        $this->authenticatorServices($container);
        $this->encoderServices($container);
        $this->providerServices($container);
    }

    /**
     *  Register services for the \Security\Config namespace.
     *
     *  @param \Pimple\Container $container
     */
    private function authenticatorServices(PimpleContainer $container)
    {
        $container['security.authenticator.jwt_authenticator'] = function (Application $app) {
            return new JwtAuthenticator();
        };

        $container['security.authenticator.password_authenticator'] = function (Application $app) {
            return new PasswordAuthenticator(
                $app['security.encoder_factory']
            );
        };

        $container['security.authenticator.password_authenticator_return_jwt_token'] = function (Application $app) {
            return new PasswordAuthenticatorReturnJwtToken(
                $app['security.encoder_factory'],
                $app['security.encoder.jwt_token_encoder']
            );
        };
    }

    /**
     *  Register services for the \Security\Encoder namespace.
     *
     *  @param \Pimple\Container $container
     */
    private function encoderServices(PimpleContainer $container)
    {
        $container['security.encoder.jwt_token_encoder'] = function (Application $app) {
            return new JwtTokenEncoder(
                $app['security.defaults']['secret_key'],
                $app['security.defaults']['token_life_time'],
                $app['security.defaults']['algorithm']
            );
        };
    }

    /**
     * Register services for the \Security\Provider namespace.
     *
     *  @param \Pimple\Container $container
     */
    private function providerServices(PimpleContainer $container)
    {
        $container['security.provider.user_provider'] = function (Application $app) {
            return new UserProvider(
                $app['db']
            );
        };
    }
}
