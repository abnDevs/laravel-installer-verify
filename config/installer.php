<?php

return [
    'prefix' => env('INSTALLER_PREFIX', 'installer'),

    'company' => [
        'name' => 'abnDevs',
        'url' => 'https://abndevs.net',
        'support_email' => 'care.abndevs@gmail.com',
        'support_phone' => '+8801322635808',
    ],

    'show_user_agreement' => env('SHOW_USER_AGREEMENT', true),
    'user_agreement_file_path' => env('USER_AGREEMENT_FILE_PATH'),

    'admin' => [
        'show_form' => true,
        'has_role' => false,
        'role' => '', // Role name ex: Super Admin
        'extra' => []
    ],

    /*
    *--------------------------------------------------------------------------
    * Server Requirements
    *--------------------------------------------------------------------------
    *
    * This is the default Laravel server requirements, you can add as many
    * as your application require, we check if the extension is enabled
    * by looping through the array and run "extension_loaded" on it.
    *
    */
    'core' => [
        'minPhpVersion' => '8.1.0',
    ],
    'final' => [
        'key' => true,
        'publish' => false,
    ],
    'requirements' => [
        'php' => [
            'cType',
            'cURL',
            'DOM',
            'FileInfo',
            'Filter',
            'Hash',
            'Mbstring',
            'OpenSSL',
            'PCRE',
            'PDO',
            'PDO_MySQL',
            'Session',
            'Tokenizer',
            'XML',
            'XMLWriter',
            'JSON',
            'BCMath',
            'GD',
        ],
    ],

    /*
    *--------------------------------------------------------------------------
    * Folders Permissions
    *--------------------------------------------------------------------------
    *
    * This is the default Laravel folders permissions, if your application
    * requires more permissions just add them to the array list below.
    *
    */
    'permissions' => [
        base_path('storage/framework/') => '775',
        base_path('storage/logs/') => '775',
        base_path('bootstrap/cache/') => '775',
    ],

    'database' => [
        'default' => 'mysql',
        'mysql' => true,
        'sqlite' => false,
        'pgsql' => false,
        'sqlsrv' => false,
    ],

    'extra' => [
        'command' => env('INSTALLER_EXTRA_COMMAND', false)
    ]
];
