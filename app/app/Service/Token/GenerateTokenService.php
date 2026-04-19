<?php

declare (strict_types = 1);

namespace App\Service\Token;

use App\Service\String\RandomStringGeneratorInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Служба для генерации уникального токена.
 */
readonly class GenerateTokenService
{
    /**
     * Максимальное кол-во попыток на создание уникального токена.
     */
    private const int MAX_ATTEMPTS = 10;

    /**
     * Создаст службу.
     *
     * @param RandomStringGeneratorInterface $randomStringGenerator Генератор строк.
     */
    public function __construct(private RandomStringGeneratorInterface $randomStringGenerator)
    {
    }

    /**
     * Сгенерирует уникальный токен для атрибута таблицы.
     *
     * @param string $tableName Название таблицы.
     * @param int    $length    Длина токена.
     * @param string $field     Атрибут таблицы в котором хранится уникальный токен.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function execute(
        string $tableName,
        int $length = 6,
        string $field = 'token'
    ): string {
        if ($length < 4) {
            throw new \Exception(
                \sprintf(
                    'Токен длиной в %d символа не сможет обеспечить достаточную уникальность.',
                    $length
                )
            );
        }

        $table = DB::table($tableName);
        $try = 0;

        do {
            if ($try > self::MAX_ATTEMPTS) {
                throw new \Exception('Превышено максимальное кол-во попыток сгенерировать уникальный токен.');
            }

            $token = $this->randomStringGenerator->generate($length);
            $try++;
        } while ($table->where($field, $token)->limit(1)->exists());

        return $token;
    }
}
