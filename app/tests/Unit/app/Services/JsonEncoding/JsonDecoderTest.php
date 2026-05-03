<?php

declare(strict_types=1);

namespace Tests\Unit\app\Services\JsonEncoding;

use App\Services\JsonEncoding\JsonDecoder;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Unit\UnitTestCase;

/**
 * Тест службы JsonDecoder.
 */
class JsonDecoderTest extends UnitTestCase
{
    /**
     * @var JsonDecoder Преобразователь строк формата JSON.
     */
    private JsonDecoder $sut;

    /**
     * Настроит тест.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->sut = new JsonDecoder();
    }

    /**
     * Источник данных для успешного преобразования.
     *
     * @return \Generator
     */
    public static function successfulDataProvider(): \Generator
    {
        $object1 = [];
        $object1[$field1 = Str::random()] = $value1 = Str::random();
        $object1[$field2 = Str::random()] = $value2 = \rand();
        $object1[$field3 = Str::random()] = null;

        $object2 = [];
        $object2[$field4 = Str::random()] = $value4 = Str::random();
        $object2[$field5 = Str::random()] = $value5 = \rand();

        yield 'Объект.' => [
            'input' => \sprintf(
                '{"%s":"%s","%s":%s,"%s":null}',
                $field1,
                $value1,
                $field2,
                $value2,
                $field3,
            ),
            'expected' => $object1,
        ];

        yield 'Массив объектов.' => [
            'input' => \sprintf(
                '[{"%s":"%s","%s":%s,"%s":null},{"%s":"%s","%s":%s}]',
                $field1,
                $value1,
                $field2,
                $value2,
                $field3,
                $field4,
                $value4,
                $field5,
                $value5,
            ),
            'expected' => [$object1, $object2],
        ];

        yield 'Пустой объект.' => [
            'input' => '{}',
            'expected' => [],
        ];
    }

    /**
     * Проверит успешный результат преобразования из формата JSON.
     *
     * @param string $input    Входные данные для преобразования.
     * @param mixed  $expected Ожидаемый резульат преобразования.
     *
     * @return void
     *
     * @throws \JsonException
     */
    #[DataProvider('successfulDataProvider')]
    public function testSuccessfulDecoding(string $input, mixed $expected): void
    {
        $result = $this->sut->decode($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Проверит неуспешное преобразование.
     *
     * @return void
     */
    public function testFailedDecoding(): void
    {
        $this->expectException(\JsonException::class);
        $this->sut->decode('<html lang="ru"></html>');
    }
}
