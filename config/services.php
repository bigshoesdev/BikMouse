<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'paypal' => [
        'username' => env('PAYPAL_USERNAME'),
        'password' => env('PAYPAL_PASSWORD'),
        'signature' => env('PAYPAL_SIGNATURE'),
        'sandbox' => true,
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT')
    ],
    'facebook' => [
        'client_id' => env('FB_ID'),
        'client_secret' => env('FB_SECRET'),
        'redirect' => env('FB_REDIRECT')
    ],
    'kakao' => [
        'client_id' => env('KAKAO_KEY'),
        'client_secret' => env('KAKAO_SECRET'),
        'redirect' => env('KAKAO_REDIRECT_URI'),
    ],
];
