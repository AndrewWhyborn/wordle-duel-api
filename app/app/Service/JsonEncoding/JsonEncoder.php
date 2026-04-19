<?php

declare(strict_types=1);

namespace App\Service\JsonEncoding;

/**
 * Преобразователь значений в формат JSON.
 */
class JsonEncoder
{
    /**
     * Флаги, с которыми по умолчанию будет выполняться преобразование.
     *
     * См. https://www.php.net/manual/ru/json.constants.php
     */
    public const int DEFAULT_OPTIONS
        = JSON_THROW_ON_ERROR
        | JSON_INVALID_UTF8_SUBSTITUTE // Преобразовывать недопустимые символы UTF-8 в \0xfffd.
        | JSON_PRESERVE_ZERO_FRACTION // Значение типа float будет преобразовано именно во float если дробная часть равна 0.
        | JSON_UNESCAPED_SLASHES // Не экранировать «/».
        | JSON_UNESCAPED_UNICODE // Не кодировать многобайтовые символы Unicode как \uXXXX.
    ;

    /**
     * Преобразует значение в формат JSON.
     *
     * @param mixed $value Преобразуемое значение.
     *
     * @return string Строка в формате JSON.
     *
     * @throws \JsonException
     */
    public static function encode(mixed $value): string
    {
        if ($value === []) {
            // Пустые массивы всегда преобразуем в пустые объекты, потому что JSON "[]" может
            // вызвать проблемы при чтении в некоторых приложениях.
            return '{}';
        }

        return (string) \json_encode($value, self::DEFAULT_OPTIONS);
    }
}
