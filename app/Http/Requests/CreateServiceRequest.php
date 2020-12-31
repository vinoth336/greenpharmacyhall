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
        $id = $this->service->id ?? null;
        return [
            'name' => "required|unique:services,slug,{$id},id",
            'description' => 'required',
            'brand' => 'required|exists:brands,id',
            'banner' => 'image|nullable|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
