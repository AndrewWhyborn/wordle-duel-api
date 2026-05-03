<?php

declare(strict_types=1);

namespace App\Http\Controllers\Game;

use App\Http\Resources\ExceptionResource;
use App\Http\Resources\GameResource;
use App\Models\Word;
use App\Services\Game\CreateGameService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для создания новой игры.
 */
readonly class CreateGameController
{
    /**
     * Создаст класс.
     *
     * @param CreateGameService $createGameService Служба для начала игры.
     */
    public function __construct(private CreateGameService $createGameService)
    {
    }

    /**
     * Создаст новую игру.
     *
     * @param Word    $word    Загаданное слово.
     * @param Request $request HTTP запрос.
     *
     * @return JsonResponse
     */
    public function __invoke(Word $word, Request $request): JsonResponse
    {
        $response = new JsonResponse();

        try {
            $game = $this->createGameService->execute(
                word: $word,
                ip: $request->ip(),
            );

            $response->setData(
                data: [
                    'game' => new GameResource($game)
                ]
            );
        } catch (\Throwable $exception) {
            $response->setStatusCode(400);
            $response->setData(new ExceptionResource($exception));
        }

        return $response;
    }
}
