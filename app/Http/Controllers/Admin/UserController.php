<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Services\Common;
use App\Services\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Model\CommonModel;
class UserController extends CommonController
{

    /**
     * 修改密码
     */
    public function adminPassword()
    {
        $this->checkUserLogin();
        if ($this->request->isMethod('post')) {
            $data = $this->request->post();
            // 数据校验
            $validatorRequest = new UserRequest();
            $validator = validator($data, $validatorRequest->customRules['password'], $validatorRequest->messages);
            if ($validator->fails()) {
                return ajaxReturnAdvError($validator->errors()->first());
            }
            // 查询旧密码进行比对
            $info = DB::table("admin_user")->find($this->uid);
            if ($info->password != Common::passwordHash($data['oldpassword'])) {
                return ajaxReturnAdvError('旧密码错误');
            }
            // 写入新密码
            $updateData = [
                'password' => Common::passwordHash($data['password']),
                'update_time' => date('Y-m-d H:i:s', time())
            ];
            if (!DB::table('admin_user')->where('id', $this->uid)->update($updateData)) {
                return ajaxReturnAdvError("密码修改失败");
            }

            return ajaxReturnAdv("密码修改成功", '');
        } else {
            return view('admin.password');
        }
    }

    /**
     * 查看用户信息|修改资料
     */
    public function profile()
    {
        $this->checkUserLogin();
        if ($this->request->isMethod('post')) {
            // 修改资料
            $data = $this->request->only(['realname', 'email', 'mobile', 'remark']);
            $data['update_time'] = date('Y-m-d H:i:s', time());
            if (DB::table("admin_user")->where("id", $this->uid)->update($data)) {
                return ajaxReturnAdv("信息修改失败");
            }
            return ajaxReturnAdvError("信息修改成功", '');
        } else {
            // 查看用户信息
            $vo = DB::table("admin_user")->select(['realname', 'email', 'mobile', 'remark'])->where("id", $this->uid)->get();
            return view('admin.profile', ['vo' => $vo]);
        }
    }

    /**
     * 检查用户是否登录
     */
    protected function checkUserLogin()
    {
        if (!Session::get(config('rbac.user_auth_key'))) {
            if ($this->request->ajax()) {
                return ajaxReturnAdvError("登录超时，请先登陆", "", "", "current", url("loginFrame"));
            } else {
                return ajaxReturnAdvError("登录超时，请先登录", config('rbac.user_auth_gateway'));
            }
        }
        return true;
    }

    public function add()
    {
        $ret = false;
        if ($this->request->ajax()) {
            $data = $this->request->except(['id']);
            $data['password']=Common::passwordHash($data['password']);
            // 验证
            $requestClass = '\App\Http\Requests\UserRequest';
            if (class_exists($requestClass)) {
                $validatorRequest = new $requestClass();
                $validator = validator($data, $validatorRequest->customRules['add'], $validatorRequest->messages);
                if ($validator->fails()) {
                    return ajaxReturnAdvError($validator->errors()->first());
                }
            }
            // 写入数据
            //使用模型写入，可以在模型中定义更高级的操作
            $model = CommonModel::insModel('User');
            if ($model->fill($data)) {
                $ret = $model->save();
            }
            if ($ret) {
                User::setRole($model->id,2);
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            return view("admin.user.add");
        }
    }

    /**
     * 修改密码
     */
    public function password()
    {
        $id = intval($this->request->input('id'));
        if ($this->request->isMethod('post')) {
            // 禁止修改管理员的密码，管理员id为1
            if ($id < 2) {
                return ajaxReturnError("缺少必要参数");
            }
            $password = $this->request->post('password');
            if (!$password) {
                return ajaxReturnError("密码不能为空");
            }
            // 写入新密码
            $updateData = [
                'password' => Common::passwordHash($password),
                'update_time' => date('Y-m-d H:i:s', time())
            ];
            if (!DB::table('admin_user')->where('id', $id)->update($updateData)) {
                return ajaxReturnAdvError("密码修改失败");
            }
            return ajaxReturnAdv("密码已修改为{$password}", '');
        } else {
            // 禁止修改管理员的密码，管理员 id 为 1
            if ($id < 2) {
                abort(403,"缺少必要参数");
            }
            return view('admin.user.password');
        }
    }

    /**
     * 编辑
     * @return mixed
     */
    public function edit()
    {
        $requestClass = '\App\Http\Requests\UserRequest';
        $ret = false;
        $id = $this->request->input('id');
        if (!$id) {
            return abort(403, '参数错误');
        }
        if ($this->request->ajax()) {
            $data = $this->request->except(['id']);
            if (class_exists($requestClass)) {
                $validatorRequest = new $requestClass();
                $validator = validator($data, $validatorRequest->customRules['edit'], $validatorRequest->messages);
                if ($validator->fails()) {
                    return ajaxReturnAdvError($validator->errors()->first());
                }
            }
            //使用模型更新，可以在模型中定义更高级的操作
            $model = CommonModel::insModel('User');
            $ret = $model->where('id', $id)->update($data);
            if ($ret) {
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            $vo = DB::table('admin_user')->find($id);
            $vo = Common::object2array($vo);
            if (!$vo) {
                abort(403, '该记录不存在');
            }
            $data = [
                'vo' => $vo
            ];
            return view("admin.user.edit", $data);
        }
    }
}
