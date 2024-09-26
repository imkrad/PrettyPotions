<?php

namespace App\Http\Resources\Staff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        switch($this->type){
            case 'App\Models\SchoolCampus':
                $name = ucwords(strtolower($this->school->name));
            break;
            case 'App\Models\LocationRegion':
                $name = $this->region;
            break;
            case 'App\Models\LocationProvince':
                $name = $this->name;
            break;
        }
        return [
            'name' => $name
        ];
    }
}
