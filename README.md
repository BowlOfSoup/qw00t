# qw00t

This project is still a work in progress! It aims to be a small quotes database, 
to be used internally in the company I work for.

#### Backend
API backend with Silex. Run to install dependencies:

    composer install

Set your environment variables:

    cp app/.env.example app/.env

#### Frontend
GIU with React/Redux/Bootstrap. Run to install dependencies:
Make sure you `cd` to `web/` first!

    npm install

To run a development build on port 8080: 

    npm run serve

To have a production build:

    npm run serve-production

#### Database
The initial project is set-up in a sqlite3 database, but you can use whatever database supported by Doctrine. 

To make a Sqlite3 database work, you have to set the group of which the http-user (www-data/apache/http) is a member of to the database file.

    chgrp yourgroupname app/yourdatabasename.sqlite3
    chgrp yourgroupname app

Database schema follows.


#### API documentation (todo)
API documentation is made in RAML, converted to HTML with raml2html.
