<?php
return [
    'api_key' => env('PAYMOB_API_KEY'),
    'secret_key' => env('PAYMOB_SECRET_KEY'),
    'public_key' => env('PAYMOB_PUBLIC_KEY'),
    'hmac_secret' => env('PAYMOB_HMAC_SECRET'),
    'notification_url' => env('PAYMOB_NOTIFICATION_URL'),
    'api_url' => env('PAYMOB_API'),
    'methods' => array_map('intval', explode(',', env('PAYMOB_METHODS'))),
];
