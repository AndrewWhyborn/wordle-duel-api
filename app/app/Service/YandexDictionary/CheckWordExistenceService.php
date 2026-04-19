<?php

declare(strict_types=1);

namespace App\Service\YandexDictionary;

use App\Service\Word\CheckWordExistenceServiceInterface;
use App\Service\YandexDictionary\Http\LookupHttpService;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * Служба проверки существования слова в Яндекс Справочнике.
 */
readonly class CheckWordExistenceService implements CheckWordExistenceServiceInterface
{
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
        return $result !== null && \count($result) > 0;
    }
}
