<?php

declare(strict_types=1);

return [

    /*
    * Адрес сервиса Яндекс Словарь
    */

    'baseUrl' => env('YANDEX_DICTIONARY_BASE_URL'),

    /*
    * АПИ-ключ сервиса Яндекс Словарь
    *
    * Можно получить по ссылке: https://yandex.ru/dev/dictionary/keys/get/?service=dict
    */

    'apiKey' => env('YANDEX_DICTIONARY_API_KEY'),
];
