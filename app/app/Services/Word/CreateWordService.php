<?php

declare(strict_types=1);

namespace App\Services\Word;

use App\Models\Word;
use App\Services\Token\GenerateTokenService;

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
     * @param string $target        Загаданное слово.
     * @param bool   $allowRetry    Разрешить повторы.
     * @param bool   $dontCheckWord Не проверять слово в словаре.
     *
     * @return Word
     *
     * @throws \Exception
     */
    public function execute(
        string $target,
        bool $allowRetry = false,
        bool $dontCheckWord = false,
    ): Word {
        $token = $this->generateTokenService->execute(tableName: Word::TABLE_NAME);

        $word = new Word();
        $word->target = \mb_strtoupper($target);
        $word->token = $token;
        $word->allow_retry = $allowRetry;
        $word->dont_check_word = $dontCheckWord;
        $word->save();

        return $word;
    }
}
