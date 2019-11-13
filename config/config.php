<?php

return [
    'services' => [
        'App\Core\Application' => [
            'arguments' => [
                'App\Core\Router'
            ]
        ],
        'App\Core\Router' => [
            'arguments' => [
                'App\Core\Container'
            ]
        ],
        'App\Model\Model' => [
            'arguments' => [
                'connection'
            ]
        ],
        'App\Controller\Controller' => [
            'arguments' => [
                'App\Core\View',
                'App\Model\Model'
            ]
        ],
        'App\Core\View' => [
            'arguments' => []
        ]
    ],
    'db' => [
        'dsn' => 'mysql:host=np_db;dbname=np',
        'username' => 'root',
        'passwd' => 'secret'
    ]
];