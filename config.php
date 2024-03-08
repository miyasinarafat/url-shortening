<?php

return [
    'shorten_base_path' => 'http://localhost:82/',

    'database' => [
        'name' => 'url_shortening',
        'username' => 'root',
        'password' => 'password',
        'port' => 3307,
        'connection' => 'mysql:host=host.docker.internal',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ],
    ],

    'redis' => [
        'host' => 'redis',
        'port' => 6379,
    ],
];
