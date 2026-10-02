<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'mercadopago' => [
        'key' => env('MP_PUBLIC_KEY'),
        'token' => env('MP_ACCESS_TOKEN'),
    ],
    'openpay' => [
        'merchant_id' => env('OPENPAY_MERCHANT_ID'),
        'private_key' => env('OPENPAY_PRIVATE_KEY'),
        'public_key' => env('OPENPAY_PUBLIC_KEY'),
        'sandbox' => env('OPENPAY_SANDBOX', true),
        'use_3d_secure' => env('OPENPAY_USE_3D_SECURE', false),
    ],

];

