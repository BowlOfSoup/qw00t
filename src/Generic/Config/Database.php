<?php

namespace Generic\Config;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;

class Database
{
    const DRIVER_SQLITE = 'pdo_sqlite';

    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        if (static::DRIVER_SQLITE === getenv('DATABASE_DRIVER')) {
            $app->register(new DoctrineServiceProvider(), array(
                'db.options' => array(
                    'driver'   => static::DRIVER_SQLITE,
                    'path'     => __DIR__.'/../../../app/' . getenv('DATABASE_FILE'),
                ),
            ));

            return;
        }

        $app->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'dbname' => getenv('DATABASE_NAME'),
                'user' => getenv('DATABASE_USER'),
                'password' => getenv('DATABASE_PASSWORD'),
                'host' => getenv('DATABASE_HOST'),
                'driver' => getenv('DATABASE_DRIVER'),
            ),
        ));
    }
}
