<?php

declare(strict_types=1);

namespace App\Http\Resources\Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Ответ с исключением.
 *
 * @mixin \Throwable
 */
class ExceptionResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->getMessage()
        ];
    }
}
