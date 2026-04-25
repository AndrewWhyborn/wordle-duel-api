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
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'target' => [
                'required',
                'string',
                'min:5',
                'max:5',
                'regex:/^[А-Яа-яЁё\s]+$/u',
                app(WordExists::class)
            ],
            'allowRetry' => [
                'boolean'
            ]
        ];
    }

    /**
     * Сообщения об ошибках валидации.
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
            'allowRetry.boolean' => 'Параметр «разрешить повторы» должен иметь логический тип.'
        ];
    }
}
