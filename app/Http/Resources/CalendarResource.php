<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   
        $title = $this->code.' - '.$this->date;
        if($this->status_id === 19){
            $color = 'bg-warning';
        }else if($this->status_id === 22){
            $color = 'bg-success';
        }else{
            $color = 'bg-info';
        }
        return [
            'id' => $this->id,
            'title' => $title,
            'start' => date("Y-m-d H:i:s",strtotime($this->date)),
            'time' => date("g:i a",strtotime($this->date)),
            'classNames' => $color,
        ];
    }
}
