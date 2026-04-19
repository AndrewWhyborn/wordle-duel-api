<?php

declare(strict_types=1);

namespace App\Service\YandexDictionary\Http;

use App\Service\JsonEncoding\JsonDecoder;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Абстрактная служба для отправки HTTP запросов в Яндекс Словарь.
 */
readonly class AbstractYandexDictionaryHttpService
{
    /**
     * Создаст службу.
     *
     * @param LoggerInterface         $logger         Служба журналирования.
     * @param ClientInterface         $httpClient     Служба HTTP запросов.
     * @param RequestFactoryInterface $requestFactory Фабрика запроса.
     * @param string                  $apiKey         АПИ-ключ.
     */
    public function __construct(
        private LoggerInterface $logger,
        private ClientInterface $httpClient,
        private RequestFactoryInterface $requestFactory,
        private string $apiKey
    ) {
    }

    /**
     * Отправит запрос.
     *
     * @param string $method HTTP метод.
     * @param string $uri    HTTP адрес.
     * @param array  $params Параметры запроса.
     *
     * @return array
     *
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function sendRequest(
        string $method,
        string $uri,
        array $params
    ): array {
        try {
            $uriWithParams = \sprintf(
                '%s?key=%s&%s',
                $uri,
                $this->apiKey,
                \http_build_query($params)
            );

            $request = $this->requestFactory->createRequest($method, $uriWithParams);
            $request = $request->withHeader('Content-Type', 'application/json');

            $this->logger->debug(
                \sprintf(
                    'Отправляем запрос "%s %s" ...',
                    $method,
                    $uriWithParams,
                ),
            );

            $response = $this->httpClient->sendRequest($request);
            $rawContents = $response->getBody()->getContents();

            $this->logger->debug(
                \sprintf(
                    'На запрос "%s %s" получен ответ. Статус "%s".',
                    $method,
                    $uriWithParams,
                    $response->getStatusCode(),
                ),
                [
                    'contents' => $rawContents
                ]
            );

            $responseData = JsonDecoder::decode($rawContents);

            if (isset($responseData['error']) && $responseData['error'] !== '') {
                throw new \Exception($responseData['error']);
            }

            return $responseData;
        } catch (\Exception $exception) {
            $this->logger->error(
                $message = \sprintf(
                    'Ошибка запроса %s %s. %s',
                    $method,
                    $uri,
                    $exception->getMessage(),
                ),
                [
                    'code' => is_a($exception, RequestExceptionInterface::class) ? $exception->getCode() : null,
                    'trace' => $exception->getTrace(),
                ],
            );

            throw new \Exception($message);
        }
    }
}
