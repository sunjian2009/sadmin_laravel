<?php

namespace App\Http\Controllers\Admin;

use App\Services\Common;
use App\Services\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends CommonController
{
    /**
     * 用户列表
     */
    public function user()
    {
        $roleId = $this->request->input('id');
        if ($this->request->isMethod('post')) {
            // 提交
            if (!$roleId) {
                return ajaxReturnAdvError("缺少必要参数");
            }
            $dbRoleUser = DB::table("admin_role_user");
            //写入新的角色绑定
            $data = $this->request->post();
            if (isset($data['user_id']) && !empty($data['user_id']) && is_array($data['user_id'])) {
                $insertAll = [];
                foreach ($data['user_id'] as $v) {
                    $insertAll[] = [
                        "role_id" => $roleId,
                        "user_id" => intval($v),
                    ];
                }
                DB::beginTransaction();
                try{
                    //删除之前的角色绑定
                    $dbRoleUser->where("role_id", $roleId)->delete();
                    $dbRoleUser->insert($insertAll);
                    DB::commit();
                    return ajaxReturnAdv("分配角色成功", '');
                }catch (\Exception $e){
                    DB::rollback();
                    return ajaxReturnAdvError("分配角色失败:".$e->getMessage(), '');
                }
            }
        } else {
            // 编辑页
            if (!$roleId) {
                abort(403, "缺少必要参数");
            }
            // 读取系统的用户列表
            $listUser = DB::table("admin_user")
                ->select(['id', 'account', 'realname'])
                ->where('status', 1)
                ->where('id', '>', 1)
                ->get()->toArray();
            $listUser = Common::object2array($listUser);
            // 已授权权限
            $listRoleUser = DB::table("admin_role_user")->where("role_id", $roleId)->select()->get()->toArray();
            $listRoleUser = Common::object2array($listRoleUser);
            $checks=$listRoleUser?filterValue($listRoleUser,'user_id'):[];
            foreach ($listUser as $key=>$value){
                $listUser[$key]['checked']=0;
                if(in_array($value['id'],$checks)){
                    $listUser[$key]['checked']=1;
                }
            }
            $data = [
                'list' => $listUser,
                'checks' => $checks
            ];

            return view('admin.role.user', $data);
        }
    }

    /**
     * 授权
     * @return mixed
     */
    public function access()
    {
        $roleId = $this->request->input('id');
        if ($this->request->isMethod('post')) {
            if (!$roleId) {
                return ajaxReturnAdvError("缺少必要参数");
            }

            if (true !== $error =Role::insertAccess($roleId, $this->request->post())) {
                return ajaxReturnAdvError($error);
            }
            return ajaxReturnAdv("权限分配成功", '');
        } else {
            if (!$roleId) {
                abort(403, "缺少必要参数");
            }
            $tree = Role::getAccessTree($roleId);
            return view('admin.role.access',['tree'=>json_encode($tree)]);
        }
    }
}
