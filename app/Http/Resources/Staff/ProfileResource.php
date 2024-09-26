<?php

namespace App\Http\Resources\Staff;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'logged' => $this->firstname.' '.$this->lastname,
            'name' => $this->lastname.', '.$this->firstname.' '.$this->middlename.'.',
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'middlename' => $this->middlename,
            'gender' => $this->gender,
            'gender_color' =>($this->gender == 'M') ? 'info' : 'warning',
            'mobile' => $this->mobile,
            'agency' => $this->agency
        ];
    }
}
