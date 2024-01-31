<?php

return [
    'whitelist_ips' => [
        '192.168.1.100', // Add your whitelisted IP addresses here
    ],

    'days' => [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ],

    'months' => [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ],

    'statusAdsSchedule' => [
        1 => 'Publish',
        2 => 'Pending',
        3 => 'Archive',
    ],

    'sourceAdsVideo' => [
        'youtube' => 'Youtube',
        'url' => 'Direct link video',
    ],

    'hotspot' => [
        'weburl' => 'https://hotspot.onexolution.id/',
        'api_maclookup' => '01h2cqkx8jtteweaxj9vgdn14m01h2cqn394d9ztxkjbnqm31mmw02rmvei1dcvx',
        'endpoint_maclookup' => 'https://api.maclookup.app',
    ],

    'statusTicket' => [
        'In Progress' => 'In Progress',
        'Pending' => 'Pending',
        'Resolved' => 'Resolved',
        'Closed' => 'Closed',
    ],

    'statusWorkOrder' => [
        'In Progress' => 'In Progress',
        'Pending' => 'Pending',
        'Resolved' => 'Resolved',
        'Cancel' => 'Cancel',
        'Closed' => 'Closed',
    ],

    'priorityWorkOrder' => [
        'High' => 'High',
        'Medium' => 'Medium',
        'Low' => 'Low',
        'Normal' => 'Normal',
        'Emergency' => 'Emergency',
    ],

    'issueCategory' => [
        'Open' => 'Open',
        'Pending' => 'Pending',
        'Resolved' => 'Resolved',
        'Closed' => 'Closed',
    ],

    'limit' => [
        'Free' => [
            'image_upload' => "1",
            'image_size' => "2",
            'custom_link' => 'No',
            'max_user' => '5',
        ],
        'Basic' => [
            'image_upload' => "3",
            'image_size' => "5",
            'custom_link' => 'No',
            'max_user' => '10',
        ],
        'Owner' => [
            'image_upload' => "-1",
            'image_size' => "-1",
            'custom_link' => 'Yes',
            'max_user' => '-1',
        ],
    ],

    'version' => [
        'major' => '0',
        'minor' => '1',
        'patch' => '0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin route settings
    |--------------------------------------------------------------------------
    |
    | The routing configuration of the admin page, including the path prefix,
    | the controller namespace, and the default middleware. If you want to
    | access through the root path, just set the prefix to empty string.
    |
    */
    'route' => [

        'prefix' => env('ADMIN_ROUTE_PREFIX', 'admin'),

        'namespace' => 'App\\Admin\\Controllers',

        'middleware' => ['web', 'auth', 'operation_log'],
    ],

    /*
    |--------------------------------------------------------------------------
    | User operation log setting
    |--------------------------------------------------------------------------
    |
    | By setting this option to open or close operation log in laravel-admin.
    |
    */
    'operation_log' => [

        'enable' => true,

        /*
         * Only logging allowed methods in the list
         */
        'allowed_methods' => ['GET', 'HEAD', 'POST', 'PUT', 'DELETE', 'CONNECT', 'OPTIONS', 'TRACE', 'PATCH'],

        /*
         * Routes that will not log to database.
         *
         * All method to path like: admin/auth/logs
         * or specific method to path like: get:admin/auth/logs.
         */
        'except' => [
            env('ADMIN_ROUTE_PREFIX', 'admin').'/auth/logs*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Company settings
    |--------------------------------------------------------------------------
    |
    |
    */
    'company' => [

        'url' => '.ludo.my.id',

        'prefix_client' => 'c',

    ],

    /*
    |--------------------------------------------------------------------------
    | System settings
    |--------------------------------------------------------------------------
    |
    |
    */
    'system' => [

        'app_name' => 'Ludo - Simplify IT Solution',

        'url' => '.ludo.my.id',

        'prefix_client' => 'c',

        'dev_disk' => 'contabo', // set system disk in filesystem.php
        
        'prod_disk' => 'contabo', // set system disk in filesystem.php
    ],

    /*
    |--------------------------------------------------------------------------
    | Semver modules settings
    |--------------------------------------------------------------------------
    |
    |
    */
    'semver' => [

        'versionStatus' => [
            'In Progress' => 'In Progress',
            'Pending' => 'Pending',
            'Release' => 'Release',
            'Planning' => 'Planning',
            'Cancel' => 'Cancel',
        ],

        'versionType' => [
            'Major' => 'Major',
            'Minor' => 'Minor',
            'Patch' => 'Patch',
        ],

        'version' => [
            'major' => '1',
            'minor' => '1',
            'patch' => '0',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Dashboard settings
    |--------------------------------------------------------------------------
    |
    |
    */
    'dashboard' => [

        'mttr' => '30', // Mean Time To Response in Minutes

        'art' => '120', // Average Resolution Time in Minutes

        'arth' => '300', // Average Resolution Time HIS in Minutes Max 5 Hours
    ],


    /*
    |--------------------------------------------------------------------------
    | ITSM settings
    |--------------------------------------------------------------------------
    |
    |
    */
    'incidentSeverity' => [
        'High' => 'High',
        'Medium' => 'Medium',
        'Low' => 'Low',
    ],
];
