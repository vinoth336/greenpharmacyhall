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
            'user_name' => 'required|alpha',
            'user_sex' => 'required|in:male,female',
            'user_phone_no' => 'required|numeric|regex:/[0-9]{10}/|unique:users,phone_no',
            'user_address' => 'required|string|max:500',
            'user_zipcode' => 'required|regex:/[0-9]{6}/',
            'user_email' => 'nullable|email:rfc,dns|unique:users,email',
            'user_password' => 'required|min:6'
        ];
    }
}
