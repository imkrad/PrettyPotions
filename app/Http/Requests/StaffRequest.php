<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'sometimes|required|max:20|unique:users,username,'.$this->id,
            'email' => 'sometimes|required|email|max:150|unique:users,email,'.$this->id,
            'firstname' => 'sometimes|required|string|max:100',
            'lastname' => 'sometimes|required|string|max:100',
            'middlename' => 'sometimes|required|string|max:50',
            'suffix' => 'sometimes|nullable|string|max:10',
            'gender' => 'sometimes|required',
            'agency_id' => 'sometimes|required',
            'mobile' => 'sometimes|required|numeric|unique:user_profiles,mobile,'.$this->profile_id,
            'img' => 'sometimes|nullable|image64:jpeg,jpg,png',
            'role' => 'sometimes|required',
            'password' => 'sometimes|required|min:6|confirmed',
            'password_confirmation' => 'sometimes|required'
        ];
    }
}
