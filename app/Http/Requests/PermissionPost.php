<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Entrust;

class PermissionPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (request()->isMethod('POST')) {
            $result = Entrust::can('permission.store');
        } else {
            $result = Entrust::can('permission.update');
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
            $rules['name'] = 'required|unique:permissions,name';
        } else {
            $rules['name'] = 'required|unique:permissions,name,'.$this->id;
            $rules['id'] = 'numeric|required';
        }
        $rules['display_name'] = 'required';
        $rules['description'] = 'required';
        $rules['uri'] = 'required';
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
            'name.required' => '请填写权限标识',
            'name.unique' => '权限标识已存在',
            'display_name.required' => '必须填写权限名',
            'description.required' => '请填写权限描述',
            'uri.required' => '请填要绑定的路由名称',
        ];
    }
}
