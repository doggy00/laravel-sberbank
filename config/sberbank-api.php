<?php

return [
    'username' => env('SBERBANK_USERNAME', ''),
    'password' => env('SBERBANK_PASSWORD', ''),
    'test' => env('SBERBANK_TEST', true),
    'testurl' => env('SBERBANK_TESTURL', 'https://3dsec.sberbank.ru/payment/'),
    'produrl' => env('SBERBANK_PRODURL', 'https://securepayments.sberbank.ru/payment/')
];