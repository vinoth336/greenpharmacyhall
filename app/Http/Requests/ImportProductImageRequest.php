<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportProductImageRequest extends FormRequest
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
            'product_images.*' => 'image|mimes:png,jpg,jpeg|max:6048',
            'product_images' => 'max:700',
            'action' => 'required|in:override,update,override_update,insert,insert_for_no_image_record'
        ];
    }
}
