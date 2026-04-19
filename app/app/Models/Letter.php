<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Буква в раунде.
 *
 * @property      int    $id         Идентификтор буквы.
 * @property      int    $round_id   Идентификатор раунда.
 * @property      int    $index      Номер буквы в слове.
 * @property      string $value      Буква.
 * @property      string $status     Статус буквы.
 * @property      string $created_at Дата создания.
 * @property      string $updated_at Дата обновления.
 *
 * @property-read Round  $round      Раунд.
 */
class Letter extends Model
{
    /**
     * Название таблицы.
     */
    public const string TABLE_NAME = 'letters';

    /**
     * Защищенные от записи поля.
     */
    private array $protected = [
        'id'
    ];

    /**
     * Раунд.
     *
     * @return BelongsTo
     */
    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class, 'round_id', 'id',);
    }
}
