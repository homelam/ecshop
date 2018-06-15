<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $rules = [
            'cat_name' => 'required|unique:categories|max:50',
            'parent_id' => Rule::notIn(['-1']),
        ];

        if ($this->method() == 'PUT') {
            $rules['cat_name'] = 'required';
        }

        return $rules;
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'cat_name.required' => '分类名称不能为空',
            'cat_name.unique' => '分类名已经存在',
            'cat_desc.max' => '分类名称不能超过30个字!',
            'parent_id.not_in' => '请选择一个分类',
        ];
    }
}
