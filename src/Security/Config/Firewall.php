<?php

namespace Security\Config;

use Generic\Controller\AbstractController;
use Generic\Service\MetaService;
use Silex\Application;
use Silex\Provider\SecurityServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\Pbkdf2PasswordEncoder;

class Firewall
{
    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        // Make sure specific environment variables are set.
        $app->before(function (Request $request, Application $app) {
            if (empty(getenv('AUTHENTICATION_SECRET'))) {
                $app->abort(500, "Environment variable AUTHENTICATION_SECRET is not set.");
            }

            if (empty(getenv('TOKEN_LIFETIME'))) {
                $app->abort(500, "Environment variable TOKEN_LIFETIME is not set.");
            }
        }, Application::EARLY_EVENT);

        // Setup the security component.
        $app->register(new SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'login' => array(
                    'pattern' => '^/api/login',
                    'stateless' => true,
                    'guard' => array(
                        'authenticators' => array(
                            'security.authenticator.password_authenticator',
                        ),
                    ),
                    'users' => function () use ($app) {
                        return $app['security.provider.user_provider'];
                    },
                ),
                'api' => array(
                    'pattern' => '^/api',
                    'stateless' => true,
                    'guard' => array(
                        'authenticators' => array(
                            'security.authenticator.jwt_authenticator',
                        ),
                    )
                ),
            )
        ));

        // Set custom password encoder.
        $app['security.default_encoder'] = function ($app) {

//            $password = new Pbkdf2PasswordEncoder();
//            var_dump($password->encodePassword('legacy', getenv('AUTHENTICATION_SECRET')));

            return new Pbkdf2PasswordEncoder();
        };

        // Handle specific security exceptions.
        $app->error(function (\Exception $e, Request $request, $code) use ($app) {
            if ($e instanceof \UnexpectedValueException) {
                if (!$app['debug']) {
                    MetaService::addMessage('We are sorry, but something went terribly wrong.');
                } else {
                    MetaService::addMessage($e->getMessage());

                    error_log($e->getMessage() . ' ' . $e->getTraceAsString());
                }

                return AbstractController::jsonResponse(array(), MetaService::getMessages(), 401);
            }

            return null;
        }, 256);
    }
}
