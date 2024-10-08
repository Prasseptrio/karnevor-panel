# Carnervor

## Installation & updates

`git clone` or download this source code then run `composer install` whenever there is a new release of the framework.

## Setup

- Copy `env` to `.env` and tailor for your app, specifically the baseURL and any database settings.
- Run `php spark db:create` to create a new database schema.
- Run `php spark migrate` to running database migration
- Run `php spark db:seed users` to seeding default database user
- Run `php spark key:generate` to create encrypter key
- Run `php spark serve` to launching the CodeIgniter PHP-Development Server

## Server Requirements

PHP version 8.0 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Features

Features on this project:

- Authentication
- Authorization
- User Registration
- Menu Management with auto create controller and view file
