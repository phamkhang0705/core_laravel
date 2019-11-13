<?php
return [
    'error' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'error/',
        'level' => 100,
        'type' => 'daily'
    ],
    'product_import' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'product_import/',
        'level' => 'debug',
        'type' => 'daily'
    ],
    'topup_retry' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'topup_retry/',
        'level' => 'debug',
        'type' => 'daily'
    ],
    'transaction_mobile' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'transaction_mobile/',
        'level' => 100,
        'type' => 'daily'
    ],
    'cashback_refund' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'cashback_refund/',
        'level' => 100,
        'type' => 'daily'
    ],
    'order' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'order/',
        'level' => 100,
        'type' => 'daily'
    ],
    'transaction_cashout' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'transaction_cashout/',
        'level' => 100,
        'type' => 'daily'
    ],
    'get_balance' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'get_balance/',
        'level' => 100,
        'type' => 'daily'
    ],
    'core' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'core/',
        'level' => 'debug',
        'type' => 'daily'
    ],

    'credit' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'credit/',
        'level' => 100,
        'type' => 'daily'
    ],

    'push_app' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'push_app/',
        'level' => 100,
        'type' => 'daily'
    ],

    'push_noti' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'push_noti/',
        'level' => 100,
        'type' => 'daily'
    ],

    'worldcup' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'worldcup/',
        'level' => 100,
        'type' => 'daily'
    ],

    'deal' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'deal/',
        'level' => 100,
        'type' => 'daily'
    ],

    'place' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'place/',
        'level' => 100,
        'type' => 'daily'
    ],

    'place_booking' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'place_booking/',
        'level' => 100,
        'type' => 'daily'
    ],

    'place' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'place/',
        'level' => 100,
        'type' => 'daily'
    ],

    'contract_appendix' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'contract_appendix/',
        'level' => 100,
        'type' => 'daily'
    ],
    'contract' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'contract/',
        'level' => 100,
        'type' => 'daily'
    ],


    'merchant_service' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'merchant_service/',
        'level' => 100,
        'type' => 'daily'
    ],

    'identity' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'identity/',
        'level' => 100,
        'type' => 'daily'
    ],
    'user' => [
        'enable' => true,
        'path' => env('LOGS_PATH') . 'user/',
        'level' => 100,
        'type' => 'daily'
    ],


];