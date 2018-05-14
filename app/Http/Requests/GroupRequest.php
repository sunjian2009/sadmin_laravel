<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
{
    public $customRules = [
        'add' => [
            'name' => 'required|unique:admin_group|between:5,20',
        ],
        'edit' => [
            'name' => 'required|between:5,20',
        ],
    ];
    public $messages = [
        'name.required' => '名称必须',
        'name.unique' => '名称已存在',
        'name.between' => '名称字符在6-20之间',
    ];





    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array

    public function messages()
    {
        return [

        ];
    }
     */

}
