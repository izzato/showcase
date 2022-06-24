<?php

return [
    'credentials' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
    'region' => env('AWS_REGION', 'us-east-1'),
    'version' => 'latest',
    'batch_max_size' => 25,
    'document_max_size' => 5000,
    'supported_sentiment_languages' => [
        'de',
        'en',
        'es',
        'it',
        'pt',
        'fr',
        'ja',
        'ko',
        'hi',
        'ar',
        'zh',
        'zh-TW',
    ],
    'supported_syntax_languages' => [
        'de',
        'en',
        'es',
        'it',
        'pt',
        'fr',
    ],
];
