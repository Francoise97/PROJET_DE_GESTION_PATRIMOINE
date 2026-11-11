<?php

return [
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '5432',
        'name' => getenv('DB_NAME') ?: 'patrimoine',
        'user' => getenv('DB_USER') ?: 'patrimoine',
        'password' => getenv('DB_PASSWORD') ?: 'patrimoine',
    ],
];
