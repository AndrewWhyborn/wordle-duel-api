<?php

declare(strict_types=1);

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use App\Http\Resources\Exception\ExceptionResponse;
use App\Http\Resources\Game\GameResponse;
use App\Models\Word;
use App\Service\Game\CreateGameService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для создания новой игры.
 */
class CreateGameController extends Controller
{
    /**
     * Создаст класс.
     *
     * @param CreateGameService $createGameService Служба для начала игры.
     */
    public function __construct(private readonly CreateGameService $createGameService)
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

            $response->setData(new GameResponse($game));
        } catch (\Throwable $exception) {
            $response->setStatusCode(400);
            $response->setData(new ExceptionResponse($exception));
        }

        return $response;
    }
}
