<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Entrust;

class RolePost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (request()->isMethod('POST')) {
            $result = Entrust::can('role.store');
        } else {
            $result = Entrust::can('role.update');
        }
        return $result;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod('POST')){
            $rules['name'] = 'required|unique:roles,name';
        } else {
            $rules['name'] = 'required|unique:roles,name,'.$this->id;
            $rules['id'] = 'numeric|required';
        }
        $rules['display_name'] = 'required';
        $rules['description'] = 'required';
        return $rules;
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请填写角色标识',
            'name.alpha' => '角色标识必须是英文',
            'name.unique' => '角色标识已存在',
            'display_name.required' => '必须填写角色名',
            'description.required' => '请填写角色描述',
        ];
    }
}
