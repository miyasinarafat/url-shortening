# URL Shortening and tracking with PHP

## Prerequisites
This software needs to be installed in your system before proceeding next step:
- Docker
- Docker Compose

## Tools
- PHP 8.2
- MySQL 8.0
- Redis 7.2.4
- `tuupola/base62`: Url encoding
- `friendsofphp/php-cs-fixer`: PSR-12
- `phpunit/phpunit`: Unit testing

## Installation
Run these commands one by one from root directory to up and running this PHP project with docker compose with dummy data:
- `docker compose build --no-cache`
- `docker compose up -d`
- `docker compose exec application composer install`

## Usage
The PHP application will be up and running to this address: http://localhost:82/. You may visit that local address to test the PHP application from web interface.

![image](https://github.com/miyasinarafat/articles-database-rest-api/assets/16781160/c696b3fb-e63d-4b9c-8b66-93e963fb6144)

## Testing
```bash
docker compose exec application composer test
```
![305182207-49175824-0f14-4aad-977f-01d1360b3e24 (1)](https://github.com/miyasinarafat/url-shortening/assets/16781160/a2021043-1f8e-48ee-9119-a6743c19bbff)


## Summery
This PHP application is unitizing `Layered Architecture` with `MVC pattern` also tried to maintain `SOLID` principles and `Docker Compose` to run PHP application with MySQL, & Redis(Queue & Cache).
```text
tree -L 2 ./src
├── app
│  ├── Controllers
│  ├── Jobs
│  ├── Models
│  ├── Repositories
│  └── Services
├── core
│  ├── App.php
│  ├── Cache.php
│  ├── Database
│  ├── Queue
│  ├── Request.php
│  ├── Router.php
│  ├── Session.php
│  ├── ValidationException.php
│  ├── Validator.php
│  ├── bootstrap.php
│  └── helpers.php
├── routes
│  └── web.php
└── views
    ├── links.view.php
    └── partials
```
