<?php

declare(strict_types=1);

namespace App\Rules\YandexDictionary;

use App\Service\Word\CheckWordExistenceServiceInterface;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Правило валидации, проверяющее существование слова.
 */
readonly class WordExists implements ValidationRule
{
    /**
     * Создаст правило.
     *
     * @param CheckWordExistenceServiceInterface $checkWordExistenceService Служба проверки существования слова.
     */
    public function __construct(
        private CheckWordExistenceServiceInterface $checkWordExistenceService
    ) {
    }

    /**
     * Проверит слово на существование.
     *
     * @param string  $attribute Атрибут.
     * @param mixed   $value     Значание.
     * @param Closure $fail      Замыкание при ошибке.
     *
     * @return void
     *
     * @throws ClientExceptionInterface
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = $this->checkWordExistenceService->check($value);

        if (!$result) {
            $fail(
                \sprintf(
                'Существительное «%s» не найдено в словаре, попробуйте другое.',
                    $value
                )
            );
        }
    }
}
