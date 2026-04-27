<?php

declare(strict_types=1);

namespace App\Http\Controllers\Game;

use App\Http\Resources\ExceptionResource;
use App\Http\Resources\GameResource;
use App\Models\Word;
use App\Service\Game\GetGameService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для получения игры.
 */
readonly class GetGameController
{
    /**
     * Создаст контроллер.
     *
     * @param GetGameService $getGameService Служба для получения игры.
     */
    public function __construct(private GetGameService $getGameService)
    {
    }

    /**
     * Вернет игру.
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
            $game = $this->getGameService->execute(
                word: $word,
                ip: $request->ip(),
            );

            $response->setData(
                data: [
                    'game' => new GameResource($game)
                ]
            );
        } catch (\Throwable $exception) {
            $statusCode = $exception->getCode();

            if ($statusCode < 100 || $statusCode >= 600) {
                $statusCode = 400;
            }

            $response->setStatusCode($statusCode);
            $response->setData(new ExceptionResource($exception));
        }

        return $response;
    }
}
