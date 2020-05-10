<?php
return [
    'params'     => [
        'appName'        => 'Simple Test App For QATestLab',
        'appDescription' => 'This App only for test, test PHP knowledge',
    ],
    'components' => [
        'Db'       => [
            'host' => 'localhost',
        ],
        'Router'   => [
            'defaultController' => 'site',
        ],
    ]
];