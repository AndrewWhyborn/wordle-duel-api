<?php

declare(strict_types=1);

namespace App\Repository\Game;

use App\Enum\GameStatusEnum;
use App\Models\Game;
use App\Models\Word;

/**
 * Репозиторий для работы с игрой.
 */
class GameRepository implements GameRepositoryInterface
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
    ): ?Game {
        return Game::query()
            ->select(
                columns: Game::TABLE_NAME . '.*'
            )
            ->join(
                table: Word::TABLE_NAME,
                first: Word::TABLE_NAME . '.id',
                operator: '=',
                second: Game::TABLE_NAME . '.word_id'
            )
            ->where(
                column: Word::TABLE_NAME . '.token',
                operator: '=',
                value: $token
            )
            ->where(
                column: Game::TABLE_NAME . '.ip',
                operator: '=',
                value: $ip
            )
            ->orderBy(
                column: Word::TABLE_NAME . '.created_at',
                direction: 'desc'
            )
            ->first()
        ;
    }

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
    ): Game {
        $game = new Game();

        $game->word_id = $word->id;
        $game->ip = $ip;
        $game->status = GameStatusEnum::IN_PROGRESS->value;
        $game->save();

        return $game;
    }
}
