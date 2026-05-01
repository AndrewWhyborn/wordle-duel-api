<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Testing\TestResponse;

/**
 * Родительский класс для feature тестов проекта.
 */
class FeatureTestCase extends TestCase
{
    /**
     * HTTP метод.
     */
    public const string METHOD = 'Указать в дочернем классе!';

    /**
     * HTTP маршрут.
     */
    public const string ROUTE = 'Указать в дочернем классе!';

    /**
     * Выполнит HTTP запрос.
     *
     * @param array|null $routeParams Параметры маршрута.
     * @param array|null $queryParams Параметры адресной строки.
     * @param array|null $headers     Заголовки запроса.
     * @param array|null $data        Данные запроса.
     *
     * @return TestResponse
     */
    protected function execute(
        ?array $routeParams = null,
        ?array $queryParams = null,
        ?array $headers = null,
        ?array $data = [],
    ): TestResponse {
        $route = static::ROUTE;

        if (!empty($queryParams)) {
            $route .= '?' . \http_build_query($queryParams);
        }

        if (!empty($routeParams)) {
            $replacements = \array_keys($routeParams);
            $values = \array_values($routeParams);

            $route = \str_replace(
                search: $replacements,
                replace: $values,
                subject: $route,
            );
        }

        return $this
            ->json(
                method: self::METHOD,
                uri: $route,
                data: $data,
                headers: $headers,
            )
        ;
    }
}
