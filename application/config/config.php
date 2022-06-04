<?php
declare(strict_types=1);

use Monolog\Logger;

return [
    // 时区
    'timezone' => 'PRC',
    // 日志
    'displayErrorDetails' => true,
    'logError' => false,
    'logErrorDetails' => false,
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../runtime/logs/app.log',
        'level' => Logger::DEBUG,
    ],
    // ID
    'id' => [
        'workerId' => 1,
        'datacenterId' => 1,
    ],
    // 数据库
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'platform',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
    // 国际化
    'i18n' => [
        'locale' => 'zh_CN',
        'resources' => [
            'zh_cn' => __DIR__ . "/../i18n/zh_cn.json",
            'en_us' => __DIR__ . "/../i18n/en_us.json"
        ],
    ],
    // 访问控制
    'rbac' => [
        'resources' => [
            '/api/user' => [
                'authenticated' > true,
                'roles' => ['administrator'],
                'authorities' => ['system:role'],
            ],
            '/api/admin/user/search' => [
                'authenticated' > true,
            ]
        ]
    ],
];
