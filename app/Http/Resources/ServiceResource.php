<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'service' => $this->service,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'category' => new DropdownResource($this->category)
        ];
    }
}
