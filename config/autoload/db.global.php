<?php

declare(strict_types=1);
// config/autoload/pdo.global.php
return [
    'db' => [
        'adapters' => [
            'TEST' => [
                'driver' => 'pdo',
                'dsn' => 'mysql:host=localhost;dbname=mezzio',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'driverOptions' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION sql_mode=\'\''
                ],
            ],
        ],
    ],
];
