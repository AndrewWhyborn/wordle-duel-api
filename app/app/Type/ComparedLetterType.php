<?php

declare(strict_types=1);

namespace App\Type;

/**
 * Результат сравнения буквы.
 */
readonly final class ComparedLetterType
{
    /**
     * Создаст результат сравнения.
     *
     * @param int    $index  Номер буквы в слове.
     * @param string $value  Буква.
     * @param string $status Статус буквы.
     */
    public function __construct(
        public int $index,
        public string $value,
        public string $status,
    ) {
    }
}
