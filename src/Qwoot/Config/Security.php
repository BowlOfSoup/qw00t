<?php

namespace Qwoot\Config;

use Generic\Controller\AbstractController;
use Security\Http\JwtResponse;
use Security\Provider\SecurityProvider;
use Silex\Application;
use Silex\Provider\SecurityServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Security
{
    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        $this->validateDependencies($app);
        $this->configureSecurity($app);
        $this->handleResponse($app);
    }

    /**
     * @param \Silex\Application $app
     */
    private function configureSecurity(Application $app)
    {
        // Setup the Silex security component.
        $app->register(new SecurityServiceProvider(), array(
            'security.firewalls' => array(
                'login' => array(
                    'pattern' => '^/api/login',
                    'stateless' => true,
                    'guard' => array(
                        'authenticators' => array(
                            'security.authenticator.password_authenticator_return_jwt_token',
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

        // Setup the custom security component.
        $app['security.defaults'] = array(
            'secret_key' => getenv('AUTHENTICATION_SECRET'),
            'token_life_time' => getenv('TOKEN_LIFETIME'),
        );
        $app->register(new SecurityProvider());

        // Set custom password encoder.
        $app['security.default_encoder'] = function(Application $app) {

//            $password = new Pbkdf2PasswordEncoder();
//            var_dump($password->encodePassword('legacy', getenv('AUTHENTICATION_SECRET')));

            return $app['security.encoder.pbkdf2'];
        };
    }

    /**
     * @param \Silex\Application $app
     */
    private function validateDependencies(Application $app)
    {
        // Make sure specific environment variables are set.
        $app->before(function (Request $request, Application $app) {
            if (empty(getenv('AUTHENTICATION_SECRET'))) {
                $app->abort(Response::HTTP_INTERNAL_SERVER_ERROR, "Environment variable AUTHENTICATION_SECRET is not set.");
            }

            if (empty(getenv('TOKEN_LIFETIME'))) {
                $app->abort(Response::HTTP_INTERNAL_SERVER_ERROR, "Environment variable TOKEN_LIFETIME is not set.");
            }
        }, Application::EARLY_EVENT);
    }

    /**
     * @param \Silex\Application $app
     */
    private function handleResponse(Application $app)
    {
        // Make sure a 'JwtResponse' gets translated to the correct format.
        $app->after(function (Request $request, Response $response) {
            if ($response instanceof JwtResponse) {
                return AbstractController::jsonResponse(json_decode($response->getContent(), true), array());
            }

            return $response;
        });
    }
}
