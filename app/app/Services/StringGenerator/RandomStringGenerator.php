<?php

declare(strict_types=1);

namespace App\Services\StringGenerator;

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
        if ($length <= 0) {
            throw new \InvalidArgumentException('Длина генерируемой строки не может равняться 0.');
        }

        return Str::random($length);
    }
}
