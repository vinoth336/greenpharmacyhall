<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceRequest extends FormRequest
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
        $serviceId = $this->service->id ?? null;
        return [
            'name' => "required|string",
            'slug_name' => "required|unique:services,slug,{$serviceId},id",
            'description' => 'nullable',
            'banner' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
