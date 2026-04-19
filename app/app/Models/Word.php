<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Загаданное слово.
 *
 * @property integer $id         Идентификтор слова.
 * @property string  $token      Токен для короткой ссылки.
 * @property string  $target     Загаданное слово.
 * @property string  $created_at Дата создания.
 * @property string  $updated_at Дата обновления.
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
}
