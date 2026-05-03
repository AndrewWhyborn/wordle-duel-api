<?php

declare(strict_types=1);

namespace App\Services\Game;

use App\Models\Game;
use App\Models\Word;
use App\Repository\Game\GameRepositoryInterface;

/**
 * Служба для получения игры.
 */
readonly class GetGameService
{
    /**
     * Создаст службу.
     *
     * @param GameRepositoryInterface $gameRepository Репозиторий для работы с игрой.
     */
    public function __construct(private GameRepositoryInterface $gameRepository)
    {
    }

    /**
     * Вернет игру.
     *
     * @param Word   $word Загаданное слово.
     * @param string $ip  IP игрока.
     *
     * @return Game
     *
     * @throws \Exception
     */
    public function execute(
        Word $word,
        string $ip,
    ): Game {
        $game = $this->gameRepository->findLastGameByTokenAndIp(
            token: $word->token,
            ip: $ip
        );

        if ($game === null) {
            throw new \Exception('Игра не найдена.', 404);
        }

        return $game;
    }
}
