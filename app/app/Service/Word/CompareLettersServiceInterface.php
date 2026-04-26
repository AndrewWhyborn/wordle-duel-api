<?php

declare(strict_types=1);

namespace App\Service\Word;

use App\Type\ComparedLetterType;

/**
 * Служба для сравнения букв двух слов.
 */
interface CompareLettersServiceInterface
{
    /**
     * @param array $targetLetters Буквы загаданного слова.
     * @param array $inputLetters  Введенные буквы.
     *
     * @return ComparedLetterType[]
     */
    public function execute(
        array $targetLetters,
        array $inputLetters
    ): array;
}
