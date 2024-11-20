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
            'value' => $this->id,
            'name' => $this->service.' ('.$this->price.')',
            'service' => $this->service,
            'description' => $this->description,
            'image' => ($this->image == 'avatar.jpg') ? $this->category->others : $this->image,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'is_active' => $this->is_active,
            'rating' => $this->ratings->count() > 0 
            ? round($this->ratings->avg('rating'), 2) 
            : null,
            'category' => new CategoryViewResource($this->category)
        ];
    }
}
