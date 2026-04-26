<?php

declare(strict_types=1);

namespace App\Http\Requests\Word;

use App\Rules\YandexDictionary\WordExists;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос на создание слова.
 */
class CreateWordRequest extends FormRequest
{
    /**
     * Вернет правила валидации.
     *
     * @return array
     */
    public function rules(): array
    {
        $targetRules = [
            'required',
            'string',
            'min:5',
            'max:5',
            'regex:/^[А-Яа-яЁё\s]+$/u',
        ];

        if ($this->input('dontCheckWord') !== true) {
            $targetRules[] = app(WordExists::class);
        }

        return [
            'target' => $targetRules,
            'allowRetry' => [
                'boolean'
            ],
            'dontCheckWord' => [
                'boolean'
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
            'target.required' => 'Необходимо ввести слово.',
            'target.min' => 'Слово должно быть длиной в 5 букв.',
            'target.max' => 'Слово должно быть длиной в 5 букв.',
            'target.regex' => 'Разрешено вводить только русские буквы.',
            'allowRetry.boolean' => 'Параметр «разрешить повторы» должен иметь логический тип.',
            'dontCheckWord.boolean' => 'Параметр «не проверять слово в словаре» должен иметь логический тип.',
        ];
    }
}
