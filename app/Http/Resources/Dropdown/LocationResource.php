<?php

namespace App\Http\Resources\Dropdown;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->code, 
            'name' => $this->name,
            'region' => $this->region
        ];
    }
}
