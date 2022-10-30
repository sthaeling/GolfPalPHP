# GolfPalPHP

## Introduction
t.b.d.

## Technology stack
Following technologies are used:
* PHP
* Symfony
* Doctrine
* Mysql

## Local Development
### Setup
#### Backend

Install project
````
composer install
````

Start database
````
docker-compose up -d
````

Edit .env file from docker compose config

Execute migrations to create database tables and relations
````
php bin/console doctrine:migrations:migrate
````

Start symfony server (requires symfony cli https://symfony.com/download)
````
symfony server:start
````
