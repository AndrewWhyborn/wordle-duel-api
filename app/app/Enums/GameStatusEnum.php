<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Состояние игры.
 */
enum GameStatusEnum: string
{
    /**
     * Игра в процессе.
     */
    case IN_PROGRESS = 'in_progress';

    /**
     * Игрок победил.
     */
    case COMPLETED = 'completed';

    /**
     * Игрок проиграл.
     */
    case FAILED = 'failed';
}
