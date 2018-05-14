<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    //laravel的验证不太灵活，有时候不同场景验证的字段不同,比如登陆和添加等等
    public $customRules = [
        'login' => [
            'account' => 'required|between:5,20',
            'password' => 'required|between:5,20',
        ],
        'add' => [
            'account' => 'required|unique:admin_user|between:5,20',
            'password' => 'required|between:5,20',
            'realname' => 'required|between:2,5',
        ],
        'edit' => [
//            'account' => 'required|between:5,20',
            'realname' => 'required|between:2,5',

        ],
        'password' => [
            'password' => 'required|between:5,20',
        ],
    ];
    public $messages = [
        'realname.between' => '姓名字符在2-5之间',
        'account.required' => '账号必须',
        'account.unique' => '账号已存在',
        'account.between' => '账号字符在6-20之间',
        'password.required' => '密码必须',
        'password.between' => '密码字符数在6-20之间',
    ];

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

        ];
    }

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
