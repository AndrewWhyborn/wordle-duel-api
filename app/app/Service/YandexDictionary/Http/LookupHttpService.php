<?php

declare(strict_types=1);

namespace App\Service\YandexDictionary\Http;

use Psr\Http\Client\ClientExceptionInterface;

/**
 * Служба для поиска слова в Яндекс Словаре.
 */
readonly class LookupHttpService extends AbstractYandexDictionaryHttpService
{
    /**
     * HTTP метод.
     */
    private const string METHOD = 'GET';

    /**
     * HTTP маршрут.
     */
    private const string ROUTE = 'lookup';

    /**
     * Найдет слово в Яндекс Словаре.
     *
     * @param string $text Слово.
     *
     * @return array|null
     *
     * @throws ClientExceptionInterface
     */
    public function execute(
        string $text
    ): ?array {
        $params = [
            'lang' => 'ru-en',
            'text' => $text,
        ];

        $responseData = $this->sendRequest(
            method: self::METHOD,
            uri: self::ROUTE,
            params: $params
        );

        return $responseData['def'] ?? null;
    }
}
