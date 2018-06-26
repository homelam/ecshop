<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            // 商品基础表需要的字段
            'goods_name' => 'required|unique:products|max:120',
            'cat_id' => 'required|exists:categories,cat_id',
            'brand_id' => 'required|exists:brands,brand_id',
            'type_id' => 'required|exists:types,type_id',
            'goods_sn' => 'nullable|unique:products',
            'goods_qty' => 'nullable|numeric',
            'goods_weight' => 'required|numeric',
            'market_price' => 'required|numeric',
            'shop_price' => 'required|numeric',
            'shop_price' => 'nullable|numeric',
            'description' => 'required|min:10'
        ];

        if ($this->method() == 'PUT') {
            $rules['goods_name'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }
}
