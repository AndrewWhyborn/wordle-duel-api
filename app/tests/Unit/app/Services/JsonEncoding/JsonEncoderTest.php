<?php

declare(strict_types=1);

namespace Tests\Unit\app\Services\JsonEncoding;

use App\Services\JsonEncoding\JsonEncoder;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Tests\Unit\UnitTestCase;

/**
 * Тест службы JsonEncoder.
 */
class JsonEncoderTest extends UnitTestCase
{
    /**
     * @var JsonEncoder Преобразователь значений в формат JSON.
     */
    private JsonEncoder $sut;

    /**
     * Настроит тест.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->sut = new JsonEncoder();
    }

    /**
     * Источник данных для успешного преобразования.
     *
     * @return \Generator
     */
    public static function successfulDataProvider(): \Generator
    {
        $object1 = new stdClass();
        $object1->{$field1 = Str::random()} = $value1 = Str::random();
        $object1->{$field2 = Str::random()} = $value2 = \rand();
        $object1->{$field3 = Str::random()} = null;

        $object2 = new stdClass();
        $object2->{$field4 = Str::random()} = $value4 = Str::random();
        $object2->{$field5 = Str::random()} = $value5 = \rand();

        yield 'Объект.' => [
            'input' => $object1,
            'expected' => \sprintf(
                '{"%s":"%s","%s":%s,"%s":null}',
                $field1,
                $value1,
                $field2,
                $value2,
                $field3,
            ),
        ];

        yield 'Массив объектов.' => [
            'input' => [$object1, $object2],
            'expected' => \sprintf(
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
        ];

        yield 'Пустой объект.' => [
            'input' => [],
            'expected' => '{}',
        ];
    }

    /**
     * Проверит успешный результат преобразования в формат JSON.
     *
     * @param mixed  $input    Входные данные для преобразования.
     * @param string $expected Ожидаемый резульат преобразования.
     *
     * @return void
     *
     * @throws \JsonException
     */
    #[DataProvider('successfulDataProvider')]
    public function testSuccessfulEncoding(mixed $input, string $expected): void
    {
        $result = $this->sut->encode($input);
        $this->assertEquals($expected, $result);
    }

    /**
     * Проверит неуспешное преобразование.
     *
     * @return void
     */
    public function testFailedEncoding(): void
    {
        $this->expectException(\JsonException::class);
        $this->sut->encode(null);
    }
}
