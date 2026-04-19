<?php

declare(strict_types=1);

namespace App\Service\Word;

use App\Models\Word;
use App\Service\Token\GenerateTokenService;

/**
 * Служба для создания загаданного слова.
 */
readonly class CreateWordService
{
    /**
     * Создаст службу.
     *
     * @param GenerateTokenService $generateTokenService Служба для генерации уникального токена.
     */
    public function __construct(private GenerateTokenService $generateTokenService)
    {
    }

    /**
     * Создаст загаданное слово.
     *
     * @param string $target Загаданное слово.
     *
     * @return Word
     *
     * @throws \Exception
     */
    public function execute(string $target): Word
    {
        $token = $this->generateTokenService->execute(tableName: Word::TABLE_NAME);

        $word = new Word();
        $word->target = $target;
        $word->token = $token;
        $word->save();

        return $word;
    }
}
