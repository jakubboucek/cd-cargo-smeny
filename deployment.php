<?php

$credentials = require __DIR__ . '/.deployment-credentials.php';

return [
    'Production' => [
        'remote' => 'ftps://prince.bukajuv.net/',
        'user' => $credentials['user'],
        'password' => $credentials['password'],
        'local' => __DIR__ . '/',
        'test' => false,
        'ignore' => '
            /.deployment-credentials.php
            /.docker
            /.gitignore
            /bin
            /composer.json
            /composer.lock
            /deployment.php
            /docker-compose.yml
            /log/*
            /temp/*
        ',
        'allowDelete' => true,
        'after' => ['https://smeny.jakubboucek.cz/deployment.php?after'],
    ],
    'tempDir' => __DIR__ . '/temp',
    'colors' => true,
    'log' => __DIR__ . '/log/deployment.log'
];
