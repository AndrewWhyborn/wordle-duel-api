<?php

declare(strict_types=1);

namespace App\Services\YandexDictionary;

use App\Services\Word\CheckWordExistenceServiceInterface;
use App\Services\YandexDictionary\Http\LookupHttpService;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Служба проверки существования слова в Яндекс Справочнике.
 */
readonly class CheckWordExistenceService implements CheckWordExistenceServiceInterface
{
    /**
     * Существительное.
     */
    private const string NOUN = 'noun';

    /**
     * Создаст службу.
     *
     * @param LookupHttpService $lookupHttpService Служба для поиска слова в Яндекс Словаре.
     */
    public function __construct(private LookupHttpService $lookupHttpService)
    {
    }

    /**
     * Проверит существование слова в Яндекс Справочнике.
     *
     * @param string $word Слово.
     *
     * @return bool
     *
     * @throws ClientExceptionInterface
     */
    public function check(string $word): bool
    {
        $result = $this->lookupHttpService->execute(text: $word);

        if (
            isset($result[0]['pos'])
            && $result[0]['pos'] === self::NOUN
        ) {
            return true;
        }

        return false;
    }
}
