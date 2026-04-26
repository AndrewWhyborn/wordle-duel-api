<?php

declare(strict_types=1);

namespace App\Http\Controllers\Round;

use App\Http\Requests\Round\CreateRoundRequest;
use App\Http\Resources\ExceptionResponse;
use App\Http\Resources\RoundResponse;
use App\Models\Game;
use App\Service\Round\CreateRoundService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для создания раунда.
 */
readonly class CreateRoundController
{
    /**
     * Создаст класс.
     *
     * @param CreateRoundService $createRoundService Служба для начала игры.
     */
    public function __construct(private CreateRoundService $createRoundService)
    {
    }

    /**
     * Создаст раунд.
     *
     * @param Game               $game    Игра.
     * @param CreateRoundRequest $request Запрос на создание раунда.
     *
     * @return JsonResponse
     */
    public function __invoke(Game $game, CreateRoundRequest $request): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $round = $this->createRoundService->execute(
                game: $game,
                letters: $request->validated()['letters'],
            );

            $response->setData(
                data: ['data' => new RoundResponse($round)]
            );
        } catch (\Throwable $exception) {
            $response->setStatusCode(400);
            $response->setData(new ExceptionResponse($exception));
        }

        return $response;
    }
}
