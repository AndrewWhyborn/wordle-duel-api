<?php

declare(strict_types=1);

namespace App\Http\Controllers\Word;

use App\Http\Requests\Word\CreateWordRequest;
use App\Http\Resources\ExceptionResource;
use App\Http\Resources\NewWordResource;
use App\Service\Word\CreateWordService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для создания загаданного слова.
 */
readonly class CreateWordController
{
    /**
     * Создаст контроллер.
     *
     * @param CreateWordService $createWordService Служба для создания загаданного слова.
     */
    public function  __construct(private CreateWordService $createWordService)
    {
    }

    /**
     * Создаст загаданное слово и вернет ссылку на игру.
     *
     * @param CreateWordRequest $request Запрос на создание слова.
     *
     * @return JsonResponse
     */
    public function __invoke(
        CreateWordRequest $request,
    ): JsonResponse {
        $response = new JsonResponse();

        try {
            $word = $this->createWordService->execute(
                target: $request->validated()['target'],
                allowRetry: $request->validated()['allowRetry'] ?? false,
                dontCheckWord: $request->validated()['dontCheckWord'] ?? false,
            );

            $response->setData(new NewWordResource($word));
        } catch (\Throwable $exception) {
            $response->setStatusCode(400);
            $response->setData(new ExceptionResource($exception));
        }

        return $response;
    }
}
