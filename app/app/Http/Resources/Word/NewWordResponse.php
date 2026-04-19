<?php

declare(strict_types=1);

namespace App\Http\Resources\Word;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ответ с данными нового загаданного слова.
 *
 * @mixin Word
 */
class NewWordResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'url' => \sprintf(
                    '%s/%s',
                    config('app.url'),
                    $this->token
                )
            ]
        ];
    }
}
