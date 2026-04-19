<?php

declare(strict_types=1);

namespace App\Service\String;

use Illuminate\Support\Str;

/**
 * Генератор строк.
 */
class RandomStringGenerator implements RandomStringGeneratorInterface
{
    /**
     * Сгенерирует строку заданной длины.
     *
     * @param int $length Длина строки.
     *
     * @return string
     */
    public function generate(int $length): string
    {
        return Str::random($length);
    }
}
