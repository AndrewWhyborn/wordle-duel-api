<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ответ с данными раунда.
 *
 * @mixin Round
 */
class RoundResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => Round::TABLE_NAME,
            'id' => $this->id,
            'attributes' => [
                'gameId' => $this->game_id,
                'index' => $this->index,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'included' => []
        ];
    }
}
