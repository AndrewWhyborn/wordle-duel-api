<?php

declare(strict_types=1);

namespace App\Services\Token;

use Illuminate\Support\Facades\DB;

/**
 * Служба для проверки наличия токена в таблице.
 */
class CheckAvailableTokenService implements CheckAvailableTokenServiceInterface
{
    /**
     * Проверит наличие токена в таблице.
     *
     * @param string $tableName Название таблицы.
     * @param string $token     Токен.
     * @param string $field     Атрибут таблицы в котором хранится уникальный токен.
     *
     * @return bool
     */
    public function execute(string $tableName, string $token, string $field = 'token'): bool
    {
        return DB::table($tableName)
            ->where($field, $token)
            ->limit(1)
            ->exists()
        ;
    }
}
