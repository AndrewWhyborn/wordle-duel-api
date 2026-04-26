<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Игра.
 *
 * @property      int     $id         Идентификтор игры
 * @property      int     $word_id    Идентификатор загаданного слова.
 * @property      string  $ip         IP игрока.
 * @property      string  $status     Статус игры.
 * @property      string  $created_at Дата создания.
 * @property      string  $updated_at Дата обновления.
 * @property-read Word    $word       Загаданное слово.
 * @property-read Round[] $rounds     Раунды игры.
 */
class Game extends Model
{
    /**
     * Название таблицы.
     */
    public const string TABLE_NAME = 'games';

    /**
     * Защищенные от записи поля.
     */
    private array $protected = [
        'id'
    ];

    /**
     * Загаданное слово.
     *
     * @return BelongsTo
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id', 'id');
    }

    /**
     * Раунды игры.
     *
     * @return HasMany
     */
    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class, 'game_id', 'id');
    }
}
