<?php

declare(strict_types=1);

namespace Tests\Unit\app\Services\StringGenerator;

use App\Services\StringGenerator\RandomStringGenerator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Unit\UnitTestCase;

/**
 * Тест службы RandomStringGenerator.
 */
class RandomStringGeneratorTest extends UnitTestCase
{
    /**
     * Генератор строк.
     */
    private RandomStringGenerator $sut;

    /**
     * Настроит тест.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->sut = new RandomStringGenerator();
    }

    /**
     * Источник данных для тестирования генерации строк.
     *
     * @return array
     */
    public static function successfulDataProvider(): array
    {
        return [
            'Строка длиной 6 символов.' => [6],
            'Строка длиной 10 символов.' => [10],
            'Строка длиной 16 символов.' => [16],
            'Строка длиной 32 символа.' => [32],
        ];
    }

    /**
     * Проверит успешную генерацию случайных строк.
     *
     * @param int $length Длина строки.
     *
     * @return void
     */
    #[DataProvider('successfulDataProvider')]
    public function testSuccessfulGeneration(int $length): void
    {
        $string1 = $this->sut->generate($length);
        $string2 = $this->sut->generate($length);

        $this->assertNotEquals($string1, $string2);
    }

    /**
     * Проверит неуспешную генерацию строки.
     *
     * @return void
     */
    public function testFailedGeneration(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sut->generate(0);
    }
}
