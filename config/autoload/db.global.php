<?php

declare(strict_types=1);
// config/autoload/pdo.global.php
return [
  
    'db' => [
        'adapters' => [
            'Test' => [
                'driver' => 'pdo_mysql',
                'dsn' => 'mysql:host=localhost;dbname=mezzio',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'driverOptions' => [
                    // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET SESSION sql_mode=\'\''
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ],
            ],
        ],
    ],
];
