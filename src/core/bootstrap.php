<?php

use App\Repositories\ShortLinkRepository;
use Core\App;
use Core\Database\{Connection, QueryBuilder, RedisConnection};

App::bind('config', require 'config.php');

App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

App::bind('redis', RedisConnection::make(App::get('config')['redis']));

App::bind(ShortLinkRepository::class, new ShortLinkRepository());
