<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ответ с буквой.
 *
 * @mixin Letter
 */
class LetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'roundId' => $this->round_id,
            'index' => $this->index,
            'value' => $this->value,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
