<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Раунд игры.
 *
 * @property      int    $id         Идентификтор раунда.
 * @property      int    $game_id    Идентификатор игры.
 * @property      int    $index      Номер раунда в игре.
 * @property      string $created_at Дата создания.
 * @property      string $updated_at Дата обновления.
 *
 * @property-read Game   $game      Игра.
 */
class Round extends Model
{
    /**
     * Название таблицы.
     */
    public const string TABLE_NAME = 'rounds';

    /**
     * Защищенные от записи поля.
     */
    private array $protected = [
        'id'
    ];

    /**
     * Игра.
     *
     * @return BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id', 'id',);
    }
}
