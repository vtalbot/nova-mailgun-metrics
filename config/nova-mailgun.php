<?php

return [
    'api_key' => env('MAILGUN_API_KEY'),
    'domain' => env('MAILGUN_DOMAIN'),
    'cache' => env('MAILGUN_CACHE', 5),
];
