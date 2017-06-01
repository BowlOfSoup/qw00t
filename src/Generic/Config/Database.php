<?php

namespace Generic\Config;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;

class Database
{
    const ID = 'generic.config.database';

    /**
     * @param \Silex\Application $app
     */
    public function setUp(Application $app)
    {
        $app->register(new DoctrineServiceProvider(), array(
            'db.options' => array(
                'driver'   => 'pdo_sqlite',
                'path'     => __DIR__.'/../../../qwoot.sqlite3',
            ),
        ));
    }
}
