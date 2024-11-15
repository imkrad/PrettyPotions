<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryViewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->id,
            'id' => $this->id,
            'name' => $this->name,
            'classification' => $this->classification,
            'type' => $this->type,
            'color' => $this->color,
            'others' => $this->others,
            'aestheticians' => AestheticianResource::collection($this->aestheticians)
        ];
    }
}
