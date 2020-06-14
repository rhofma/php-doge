<?php

require_once __DIR__ . '/dirty/config.php';
require_once __DIR__ . '/dirty/debug.php';
require_once __DIR__ . '/dirty/router.php';
require_once __DIR__ . '/dirty/database.php';
require_once __DIR__ . '/dirty/response.php';
require_once __DIR__ . '/dirty/auth.php';
require_once __DIR__ . '/dirty/validation.php';
require_once __DIR__ . '/dirty/email.php';

config([
    'group' => 'path',
    'configs' => [
        'base' => __DIR__,
        'actions' => __DIR__ . '/actions',
        'database' => __DIR__ . '/database',
        'dirty' => __DIR__ . '/dirty',
        'public' => __DIR__ . '/public',
        'views' => __DIR__ . '/views',
        'vendor' => __DIR__ . '/vendor',
    ]
]);

read_config();
register_error_handler();
