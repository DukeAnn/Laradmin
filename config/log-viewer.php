<?php

use Arcanedev\LogViewer\Contracts\Utilities\Filesystem;

return [
    /* ------------------------------------------------------------------------------------------------
     |  Log files storage path
     | ------------------------------------------------------------------------------------------------
     */
    'storage-path'  => storage_path('logs'),

    /* ------------------------------------------------------------------------------------------------
     |  Log files pattern
     | ------------------------------------------------------------------------------------------------
     */
    'pattern'       => [
        'prefix'    => Filesystem::PATTERN_PREFIX,    // 'laravel-'
        'date'      => Filesystem::PATTERN_DATE,      // '[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]'
        'extension' => Filesystem::PATTERN_EXTENSION, // '.log'
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Locale
     | ------------------------------------------------------------------------------------------------
     |  Supported locales :
     |    'auto', 'ar', 'bg', 'de', 'en', 'es', 'et', 'fa', 'fr', 'hu', 'hy', 'it', 'ko', 'nl', 'pl',
     |    'pt-BR', 'ro', 'ru', 'sv', 'th', 'tr', 'zh-TW', 'zh'
     */
    'locale'        => 'zh',

    /* ------------------------------------------------------------------------------------------------
     |  Route settings
     | ------------------------------------------------------------------------------------------------
     */
    'route'         => [
        'enabled'    => false,

        'attributes' => [
            'prefix'     => 'admin/log',

            'middleware' => ['auth'],
        ],
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Log entries per page
     | ------------------------------------------------------------------------------------------------
     |  This defines how many log entries are displayed per page.
     */
    'per-page'      => 10,

    /* ------------------------------------------------------------------------------------------------
     |  LogViewer's Facade
     | ------------------------------------------------------------------------------------------------
     */
    'facade'        => 'LogViewer',

    /* ------------------------------------------------------------------------------------------------
     |  Download settings
     | ------------------------------------------------------------------------------------------------
     */
    'download'      => [
        'prefix'    => 'laravel-',

        'extension' => 'log',
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Menu settings
     | ------------------------------------------------------------------------------------------------
     */
    'menu'  => [
        'filter-route'  => 'log.filter',

        'icons-enabled' => true,
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Icons
     | ------------------------------------------------------------------------------------------------
     */
    'icons' =>  [
        /**
         * Font awesome >= 4.3
         * http://fontawesome.io/icons/
         */
        'all'       => 'fa fa-fw fa-list',                 // http://fontawesome.io/icon/list/
        'emergency' => 'fa fa-fw fa-bug',                  // http://fontawesome.io/icon/bug/
        'alert'     => 'fa fa-fw fa-bullhorn',             // http://fontawesome.io/icon/bullhorn/
        'critical'  => 'fa fa-fw fa-heartbeat',            // http://fontawesome.io/icon/heartbeat/
        'error'     => 'fa fa-fw fa-times-circle',         // http://fontawesome.io/icon/times-circle/
        'warning'   => 'fa fa-fw fa-exclamation-triangle', // http://fontawesome.io/icon/exclamation-triangle/
        'notice'    => 'fa fa-fw fa-exclamation-circle',   // http://fontawesome.io/icon/exclamation-circle/
        'info'      => 'fa fa-fw fa-info-circle',          // http://fontawesome.io/icon/info-circle/
        'debug'     => 'fa fa-fw fa-life-ring',            // http://fontawesome.io/icon/life-ring/
    ],

    /* ------------------------------------------------------------------------------------------------
     |  Colors
     | ------------------------------------------------------------------------------------------------
     */
    'colors' =>  [
        'levels'    => [
            'empty'     => 'default',
            'all'       => 'green',
            'emergency' => 'red-thunderbird',
            'alert'     => 'red',
            'critical'  => 'red-flamingo',
            'error'     => 'red-haze',
            'warning'   => 'yellow-crusta',
            'notice'    => 'yellow-soft',
            'info'      => 'blue',
            'debug'     => 'blue-soft',
        ],
    ],
];
