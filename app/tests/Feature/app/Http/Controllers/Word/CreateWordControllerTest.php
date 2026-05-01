<?php

declare(strict_types=1);

namespace Tests\Feature\app\Http\Controllers\Word;

use App\Http\Enum\ApiHeaderEnum;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Feature\FeatureTestCase;

/**
 * Тест метода "POST /api/v1/words".
 */
class CreateWordControllerTest extends FeatureTestCase
{
    /**
     * HTTP метод.
     */
    public const string METHOD = 'POST';

    /**
     * HTTP маршрут.
     */
    public const string ROUTE = '/api/v1/words';

    /**
     * Источник данных для тестирования ошибок валидации.
     *
     * @return \Generator
     */
    public static function unauthorizedRequestDataProvider(): \Generator
    {
        yield 'Пустой заголовок.' => [
            'headers' => [],
        ];

        yield 'Неверный заголовок.' => [
            'headers' => [
                ApiHeaderEnum::X_AUTH_TOKEN => Str::random(),
            ],
        ];
    }

    /**
     * Проверит неавторизованный запрос.
     *
     * @param array $headers Заголовки.
     *
     * @return void
     */
    #[DataProvider('unauthorizedRequestDataProvider')]
    public function testUnauthorizedRequest(array $headers): void
    {
        $response = $this->execute(
            headers: $headers,
        );

        $response->assertStatus(401);
    }
}
