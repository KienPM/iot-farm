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
    'nganluong' => [
        'url' => env('NGAN_LUONG_URL', 'https://www.nganluong.vn/checkout.php'),
        'receiver' => env('RECEIVER', 'hoanghoi1310@gmail.com'), // Email tài khoản Ngân Lượng
        'merchant_id' => env('MERCHANT_ID', '12344321'), // Mã kết nối
        'merchant_pass' => env('MERCHANT_PASS', '12345678'),  // Mật khẩu kết nối
        'affiliate_code' => env('AFFILIATE_CODE', ''), ////Mã đối tác tham gia chương trình liên kết của NgânLượng.vn
    ]
];
