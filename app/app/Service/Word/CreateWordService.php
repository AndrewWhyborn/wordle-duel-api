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
        $word = new Word();
        $word->target = $target;
        $word->token = $this->generateTokenService->execute(tableName: Word::TABLE_NAME);
        $word->save();

        return $word;
    }
}
