<?php

declare(strict_types=1);

namespace App\Rules\YandexDictionary;

use App\Service\YandexDictionary\Http\LookupHttpService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Правило валидации, проверяющее существование слова.
 */
readonly class WordExists implements ValidationRule
{
    public function __construct(private LookupHttpService $lookupHttpService)
    {
    }

    /**
     * Проверит слово.
     *
     * @param string $attribute Атрибут.
     * @param mixed $value Значание.
     * @param Closure $fail Замыкание при ошибке.
     *
     * @return void
     *
     * @throws ClientExceptionInterface
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $result = $this->lookupHttpService->execute(text: $value);

        if ($result === null || \count($result) === 0) {
            $fail(
                \sprintf(
                'Слово «%s» не найдено в словаре, попробуйте другое.',
                    $value
                )
            );
        }
    }
}
