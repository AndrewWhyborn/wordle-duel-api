<?php

declare(strict_types=1);

namespace App\Http\Enum;

/**
 * Заголовок для работы с API.
 */
interface ApiHeaderEnum
{
    /**
     * Секретный ключ API.
     */
    public const string X_AUTH_TOKEN = 'X-Auth-Token';
}
