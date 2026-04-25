<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Models\Game;
use App\Models\Word;

/**
 * Репозиторий для работы с игрой.
 */
interface GameRepositoryInterface
{
    /**
     * Найдет игру по токену слова и IP игрока.
     *
     * @param string $token Токен загаданного слова.
     * @param string $ip    IP игрока.
     *
     * @return Game|null
     */
    public function findLastGameByTokenAndIp(
        string $token,
        string $ip
    ): ?Game;

    /**
     * Создаст новую игру.
     *
     * @param Word   $word Загадонное слово.
     * @param string $ip   IP игрока.
     *
     * @return Game
     */
    public function createGame(
        Word $word,
        string $ip
    ): Game;
}
