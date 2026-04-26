<?php

declare(strict_types=1);

namespace App\Http\Requests\Round;

use App\Rules\YandexDictionary\WordExists;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос на создание раунда.
 */
class CreateRoundRequest extends FormRequest
{
    /**
     * Вернет правила валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'letters' => [
                'required',
                'array',
                'min:5',
                'max:5',
            ],
            'letters.*' => [
                'regex:/^[А-Яа-яЁё\s]+$/u',
                'min:1',
                'max:1',
            ]
        ];
    }

    /**
     * Вернет сообщения об ошибках валидации.
     *
     * @return array|string[]
     */
    public function messages(): array
    {
        return [
            'letters.required' => 'Необходимо ввести слово.',
            'letters.min' => 'Слово должно быть длиной в 5 букв.',
            'letters.max' => 'Слово должно быть длиной в 5 букв.',
            'letters.array' => 'Слово должно быть передано в виде массива отдельных букв.',
            'letters.*.regex' => 'Разрешено вводить только русские буквы.',
            'letters.*.min' => 'Слово должно быть передано в виде массива отдельных букв.',
            'letters.*.max' => 'Слово должно быть передано в виде массива отдельных букв.',
        ];
    }
}
