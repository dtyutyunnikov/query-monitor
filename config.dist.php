<?php

return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'name' => 'mysql',
        'user' => 'root',
        'pass' => '',
    ],
    'auth' => 'admin:pass',
    'views' => __DIR__ . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR,
    'routes' => __DIR__ . DIRECTORY_SEPARATOR . 'routes.php',
];
