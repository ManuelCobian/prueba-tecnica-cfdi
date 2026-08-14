<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

     'inegi' => [
        'host' => env('INEGI_HOST', 'https://gaia.inegi.org.mx/wscatgeo/v2/mgee'),
    ],

     'sat' => [
            'namespace' => env(
            'SAT_NAMESPACE',
            'http://www.sat.gob.mx/cfd/4'
        ),

        'xsi_namespace' => env(
            'SAT_XSI_NAMESPACE',
            'http://www.w3.org/2001/XMLSchema-instance'
        ),

        'xsd' => env(
            'SAT_XSD',
            'https://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd'
        ),

        'xsd_local' => env(
            'SAT_XSD_LOCAL',
            'resources/xsd/cfdv40.xsd'
        ),
    ],

];
