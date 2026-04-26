<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Загаданное слово.
 *
 * @property      int     $id              Идентификтор слова.
 * @property      string  $token           Токен для короткой ссылки.
 * @property      string  $target          Загаданное слово.
 * @property      boolean $allow_retry     Разрешено ли переиграть.
 * @property      boolean $dont_check_word Не проверять слово в словаре.
 * @property      string  $created_at      Дата создания.
 * @property      string  $updated_at      Дата обновления.
 *
 * @property-read Game[]  $games       Игры с этим загаданным словом.
 */
class Word extends Model
{
    /**
     * Название таблицы.
     */
    public const string TABLE_NAME = 'words';

    /**
     * Защищенные от записи поля.
     */
    private array $protected = [
        'id'
    ];

    /**
     * Ключ для поиска сущности.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'token';
    }

    /**
     * Игры с этим загаданным словом.
     *
     * @return HasMany
     */
    public function games(): HasMany
    {
        return $this->hasMany(Game::class, 'word_id', 'id');
    }
}
