<?php

declare(strict_types=1);

namespace App\Http\Controllers\Word;

use App\Http\Requests\Word\CreateWordRequest;
use App\Service\CreateWordService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Контроллер для создания загаданного слова.
 */
readonly class CreateWordController
{
    /**
     * Создаст класс.
     *
     * @param CreateWordService $createWordService Валидатор запроса на создание слова.
     */
    public function  __construct(private CreateWordService $createWordService)
    {
    }

    /**
     * Создаст загаданное слово и вернет ссылку на игру.
     *
     * @param CreateWordRequest $request
     *
     * @return JsonResponse
     */
    public function __invoke(
        CreateWordRequest $request,
    ): JsonResponse {
        $response = new JsonResponse();

        try {
            $url = $this->createWordService->execute(
                target: $request->validated()['target']
            );

            $response->setData(
                data: ['url' => $url]
            );
        } catch (\Throwable $exception) {
            $response->setStatusCode(400);
            $response->setData(
                data: ['error' => $exception->getMessage()]
            );
        }

        return $response;
    }
}
