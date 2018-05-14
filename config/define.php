<?php

return [

    'site' => [
        'keywords' => '',
        'description' => '',
        'version' => '',
        'url' => env('APP_URL') . '/public/',
        'version' => 0.1,
        // 登录地址
        'logout_url' => PHP_SAPI === 'cli' ? false :url('admin/logout'),
        'login_frame' => PHP_SAPI === 'cli' ? false :url('admin/loginFrame')
    ],
    'paginate'=>[
        'list_rows'=>20
    ],
    'compiled' => realpath(storage_path('framework/views')),

];
