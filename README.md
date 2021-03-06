# qw00t

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-blue.svg?no-cache=1)](https://php.net/) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/550fa6fd-03db-4387-a1bf-01a2f775dabf/mini.png)](https://insight.sensiolabs.com/projects/550fa6fd-03db-4387-a1bf-01a2f775dabf)

This project is still a work in progress! It aims to be a small quote database.

#### Backend
API backend with [Silex](https://github.com/silexphp/Silex). Run to install dependencies:

    composer install

Set your environment variables:

    cp app/.env.example app/.env

#### Frontend
GUI with [React](https://github.com/facebook/react)/[Redux](https://github.com/reactjs/redux)/[Bootstrap](https://github.com/twbs/bootstrap). Run to install dependencies:
Make sure you `cd` to `web/` first!

    npm install

To run a development build on port 8080: 

    npm run serve

To have a production build:

    npm run serve-production

#### Database
The initial project is set-up in a sqlite3 database, but you can use whatever database supported by [Doctrine](https://github.com/doctrine/dbal).

To make a Sqlite3 database work, you have to set the group of which the http-user (www-data/apache/http) is a member of to the database file.

    chgrp yourgroupname app/yourdatabasename.sqlite3
    chmod 775 app/yourdatabasename.sqlite3
    chgrp yourgroupname app
    chmod 775 app

See [here](https://github.com/BowlOfSoup/qw00t/wiki/SQL-dump) for the database queries to setup the database.

#### API documentation
API documentation is made in [RAML](https://github.com/raml-org/raml-spec), converted to HTML with [raml2html](https://github.com/raml2html/raml2html).

To view API documentation, visit http://yourqw00turl/doc. To (re)generate the documentation run:

    cd doc
    raml2html api.raml > index.html
