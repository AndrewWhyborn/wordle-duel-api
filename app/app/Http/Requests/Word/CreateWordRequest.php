<?php

declare(strict_types=1);

namespace App\Http\Requests\Word;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Валидатор запроса на создание слова.
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
            'target' => 'required|string|min:5|max:5|regex:/^[А-Яа-яЁё\s]+$/u',
        ];
    }
}
