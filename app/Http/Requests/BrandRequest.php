<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'brand_name' => 'bail|required|unique:brands|max:60',
            'sort_order' => 'bail|required|integer',
            'is_show' => 'required|accepted:0,1',
            'brand_desc' => 'required|max:255'
        ];
    }
}
