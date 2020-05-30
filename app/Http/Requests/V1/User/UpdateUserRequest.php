<?php

namespace App\Http\Requests\V1\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => [
                'required',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:1500'
        ];
    }
}
