<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\Word;

/**
 * Служба для создания загаданного слова.
 */
class CreateWordService
{
    /**
     * Создаст загаданное слово и вернет ссылку на игру.
     *
     * @param string $target Загаданное слово.
     *
     * @return string
     */
    public function execute(string $target): string
    {
        $word = new Word();
        $word->target = $target;
        $word->url = 'H0kgjdlkgjdsl';
        $word->save();

        return $word->url;
    }
}
