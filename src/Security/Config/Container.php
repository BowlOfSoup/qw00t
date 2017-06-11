<?php

namespace Security\Config;

use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use Security\Authenticator\JwtTokenAuthenticator;
use Security\Authenticator\PasswordAuthenticator;
use Security\Authenticator\PasswordAuthenticatorReturnJwtToken;
use Security\Controller\UserController;
use Security\Encoder\JwtTokenEncoder;
use Security\Encoder\PasswordEncoder;
use Security\FormType\UserFormType;
use Security\Provider\UserProvider;
use Security\Repository\UserRepository;
use Security\Service\UserService;
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
        // Authenticator services.
        $container['security.authenticator.jwt_token_authenticator'] = function (Application $app) {
            return new JwtTokenAuthenticator(
                $app['security.encoder.jwt_token_encoder'],
                $app['security.defaults']['authorization_header']
            );
        };
        $container['security.authenticator.password_authenticator'] = function (Application $app) {
            return new PasswordAuthenticator(
                $app['security.encoder_factory'],
                $app['security.defaults']['secret_key'],
                $app['security.defaults']['authorization_header']
            );
        };
        $container['security.authenticator.password_authenticator_return_jwt_token'] = function (Application $app) {
            return new PasswordAuthenticatorReturnJwtToken(
                $app['security.encoder_factory'],
                $app['security.encoder.jwt_token_encoder'],
                $app['security.defaults']['secret_key'],
                $app['security.defaults']['authorization_header']
            );
        };

        // Controller services.
        $container['security.controller.user_controller'] = function (Application $app) {
            return new UserController(
                $app['security.service.user_service'],
                $app['security.form_type.user_form_type']
            );
        };

        // Encoder services.
        $container['security.encoder.jwt_token_encoder'] = function (Application $app) {
            return new JwtTokenEncoder(
                $app['security.defaults']['token_life_time'],
                $app['security.defaults']['secret_key'],
                $app['security.defaults']['token_algorithm']
            );
        };
        $container['security.encoder.password_encoder'] = function (Application $app) {
            return new PasswordEncoder(
                $app['security.default_encoder'],
                $app['security.defaults']['secret_key'],
                $app['security.defaults']['password_strength_regex'],
                $app['security.defaults']['messages']['password_strength_error']
            );
        };

        // FormType services.
        $container['security.form_type.user_form_type'] = function (Application $app) {
            return new UserFormType(
                $app['form.factory']
            );
        };

        // Provider services.
        $container['security.provider.user_provider'] = function (Application $app) {
            return new UserProvider(
                $app['security.repository.user_repository']
            );
        };

        // Repository services.
        $container['security.repository.user_repository'] = function (Application $app) {
            return new UserRepository(
                $app['db']
            );
        };

        // Service services.
        $container['security.service.user_service'] = function (Application $app) {
            return new UserService(
                $app['security.repository.user_repository'],
                $app['security.encoder.password_encoder'],
                $app['security.token_storage'],
                $app['security.defaults']['messages']['username_or_email_already_in_use_error']
            );
        };
    }
}
