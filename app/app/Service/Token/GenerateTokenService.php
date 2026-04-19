<?php

declare (strict_types = 1);

namespace App\Service\Token;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Служба для генерации уникального токена.
 */
class GenerateTokenService
{
    /**
     * Сгенерирует уникальный токен для атрибута таблицы.
     *
     * @param string $tableName Название таблицы.
     * @param int $tokenLength Длина токена.
     * @param string $field Атрибут таблицы в котором хранится уникальный токен.
     *
     * @return string
     *
     * @throws \Exception
     */
    public function execute(
        string $tableName,
        int $tokenLength = 6,
        string $field = 'token'
    ): string {
        if ($tokenLength < 4) {
            throw new \Exception(
                \sprintf(
                    'Токен длиной в %d символа не сможет обеспечить достаточную уникальность.',
                    $tokenLength
                )
            );
        }

        $table = DB::table($tableName);

        do {
            $token = Str::random($tokenLength);
        } while ($table->where($field, $token)->limit(1)->exists());

        return $token;
    }
}
