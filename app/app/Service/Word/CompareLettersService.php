<?php

declare(strict_types=1);

namespace App\Service\Word;

use App\Enum\LetterStatusEnum;
use App\Type\ComparedLetterType;

/**
 * Служба для сравнения букв двух слов.
 */
class CompareLettersService implements CompareLettersServiceInterface
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
    ): array {
        $result = [];

        foreach ($inputLetters as $inputIndex => $inputLetter) {
            $status = LetterStatusEnum::FAR;

            foreach ($targetLetters as $targetIndex => $targetLetter) {
                if (\mb_strtoupper($inputLetter) === $targetLetter) {
                    if ($inputIndex === $targetIndex) {
                        $status = LetterStatusEnum::SUCCESS;
                    } elseif ($status === LetterStatusEnum::FAR) {
                        $status = LetterStatusEnum::NEAR;
                    }
                }
            }

            $result[] = new ComparedLetterType(
                index: $inputIndex + 1,
                value: $inputLetter,
                status: $status->value,
            );
        }

        return $result;
    }
}
