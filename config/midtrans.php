<?php

return [
    'serverKey' => env('MIDTRANS_SERVER_KEY'),
    'clientKey' => env('MIDTRANS_CLIENT_KEY'),
    'isProduction' => env('MIDTRANS_IS_PRODUCTION', false), // Tambahkan default false
    'isSanitized' => env('MIDTRANS_IS_SANITIZED', true), // Tambahkan default true
    'is3ds' => env('MIDTRANS_IS_3DS', true), // Tambahkan default true
];