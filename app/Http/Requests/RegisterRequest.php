<?php

namespace App\Http\Requests;

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
            'name' => 'required|string|max:32',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8'
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
             'name.required' => 'Email is required!',
             'email.required' => 'Email is required!',
             'password.required' => 'Password is required!'
         ];
     }
 }

