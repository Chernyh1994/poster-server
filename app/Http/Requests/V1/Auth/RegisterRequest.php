<?php

namespace App\Http\Requests\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:32',
            'email' => 'required|string|email|unique:users,email|min:5|max:255',
            'password' => 'required|string|min:8|max:32'
        ];
    }

    /**
     * Custom message for validation
    *
    * @return array
    */
    public function messages()
    {
        return [
            'email.unique' => 'A user with this email is already registered in the system',
        ];
    }
}

