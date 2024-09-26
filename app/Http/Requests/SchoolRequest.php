<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if($this->type == 'campus'){
            return [
                'campus' => 'sometimes|required',
                'oldname' => 'sometimes|string',
                'address' => 'sometimes|required',
                'school_id' => 'sometimes|required',
                'term_id' => 'sometimes|required',
                'grading_id' => 'sometimes|required',
                'region_code' => 'sometimes|required',
                'province_code' => 'sometimes|required',
                'municipality_code' => 'sometimes|required',
                'assigned_region' => 'sometimes|required',
            ];
        }else{
            return [
                'name' => 'sometimes|required|unique:schools,name,'.$this->id,
                'shortcut' => 'sometimes|required',
                'class_id' => 'sometimes|required'
            ];
        }
    }
}
