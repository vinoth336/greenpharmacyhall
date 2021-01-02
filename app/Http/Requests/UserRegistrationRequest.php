<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
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
            'name' => 'required|alpha',
            'sex' => 'required|in:male,female',
            'phone_no' => 'required|numeric|regex:/[0-9]{10}/|unique:users,phone_no',
            'address' => 'required|string|max:500',
            'zipcode' => 'required|regex:/[0-9]{6}/',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|min:6'
        ];
    }
}
