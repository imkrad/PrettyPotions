<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       if($this->type == 'semester'){
            return [
                'academic_year' => 'required',
                'start_at' => 'required',
                'end_at' => 'required',
                'semester_id' => 'required|unique:school_semesters,semester_id,NULL,id,school_id,' . $this->school_id . ',academic_year,' . $this->academic_year,
                'school_id' => 'required'
            ];
        }else if($this->type == 'prospectus'){
            return [
                'school_year' => 'sometimes|required'
            ];
        }else if($this->type == 'grading'){
            return [
                'grade' => 'sometimes|required',
                'lower_limit' => 'sometimes|required',
                'upper_limit' => 'sometimes|required'
            ];
        }else if($this->type == 'truncate'){
            return [];
        }else{
            return [
                'course_id' => 'required',
                'type' => 'nullable|string|max:100|unique:school_courses,type,NULL,'.$this->id.',course_id,'.$this->course_id, //,school_id,'.$this->school_id,'
                'years' => 'required'
            ];
       }
    }

    public function messages()
    {
        if($this->type == 'semester'){
            $message = [
                'academic_year.required' => 'required',
                'start_at.required' => 'required',
                'end_at.required' => 'required',
                'semester_id.required' => 'required',
            ];
        }else if($this->type == 'prospectus'){
            $message = [
                'school_year.required' => 'required'
            ];
        }else if($this->type == 'grading'){
            $message = [
                'grade.required' => 'Required',
                'upper_limit.required' => 'Required',
                'lower_limit.required' => 'Required'
            ];
        }else{
            $message = [
                'course_id.required' => 'required',
                'years.required' => 'required'
            ];
        }
        return $message;
    }
}
