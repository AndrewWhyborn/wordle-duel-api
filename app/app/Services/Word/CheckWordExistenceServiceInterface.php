<?php

declare(strict_types=1);

namespace App\Services\Word;

/**
 * Служба проверки существования слова.
 */
interface CheckWordExistenceServiceInterface
{
    /**
     * Проверит существование слова.
     *
     * @param string $word Слово.
     *
     * @return bool
     */
    public function check(string $word): bool;
}
