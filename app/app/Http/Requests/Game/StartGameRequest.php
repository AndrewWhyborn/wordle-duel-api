<?php

declare(strict_types=1);

namespace App\Http\Requests\Game;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Запрос для старта игры.
 */
class StartGameRequest extends FormRequest
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
            'token' => 'required|string',
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
            'token.required' => 'Необходимо указать токен.',
            'token.string' => 'Токен должен быть строкой.',
        ];
    }
}
