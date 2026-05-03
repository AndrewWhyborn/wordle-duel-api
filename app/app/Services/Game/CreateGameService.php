<?php

declare(strict_types=1);

namespace App\Services\Game;

use App\Enums\GameStatusEnum;
use App\Models\Game;
use App\Models\Word;
use App\Repository\Game\GameRepositoryInterface;
use Psr\Log\LoggerInterface;

/**
 * Служба для начала игры.
 */
readonly class CreateGameService
{
    /**
     * Создаст службу.
     *
     * @param GameRepositoryInterface $gameRepository Репозиторий для работы с игрой.
     * @param LoggerInterface         $logger         Служба журналирования.
     */
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private LoggerInterface $logger,
    ) {
    }

    /**
     * Начнет игру.
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

        if ($game !== null) {
            if ($game->status === GameStatusEnum::COMPLETED->value) {
                throw new \Exception('Вы уже отгадали это слово.');
            } elseif (
                $game->status === GameStatusEnum::FAILED->value
                && $word->allow_retry === false
            ) {
                throw new \Exception('Автор игры запретил повторные попытки.');
            }

            throw new \Exception('Игра уже создана.');
        }

        $game = $this->gameRepository->createGame(
            word: $word,
            ip: $ip
        );

        $this->logger->info(
            \sprintf(
                'Пользователь %s начал новую игру %s со словом %s.',
                $ip,
                $game->id,
                $word->id,
            )
        );

        return $game;
    }
}
