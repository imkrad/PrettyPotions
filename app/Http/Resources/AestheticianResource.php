<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AestheticianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->aesthetician->id,
            'name' => $this->aesthetician->user->profile->firstname.' '.$this->aesthetician->user->profile->lastname
        ];
    }
}
