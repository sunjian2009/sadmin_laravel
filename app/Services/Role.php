<?php
/**
 * Created by PhpStorm.
 * User: pla
 * Date: 2018/1/23
 * Time: 21:47
 */

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Services\Common;

class Role
{
    /**
     * 写入权限
     * @param $role_id
     * @param $data
     * @return bool|string
     */
    public static function insertAccess($roleId, $data)
    {
        DB::beginTransaction();
        try {
            $dbAccess = Db::table("admin_access");
            //删除之前的权限分配
            $dbAccess->where("role_id", $roleId)->delete();
            //写入新的权限分配
            if (isset($data['node_id']) && !empty($data['node_id']) && is_array($data['node_id'])) {
                $insertAll = [];
                foreach ($data['node_id'] as $v) {
                    $node = explode('_', $v);
                    if (!isset($node[2])) {
                        abort(403,'参数错误');
                    }
                    $insertAll[] = [
                        "role_id" => $roleId,
                        "node_id" => $node[0],
                        "level" => $node[1],
                        "pid" => $node[2],
                    ];
                }
                $dbAccess->insert($insertAll);
            }
            // 提交事务
            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            return $e->getMessage();
        }
    }

    /**
     * 生成权限树
     * @param $role_id
     * @return array
     */
    public static function getAccessTree($roleId)
    {
        //分组信息
        $listGroup = DB::table('admin_group')
            ->where('status', 1)
            ->where('is_delete', 0)
            ->get()->toArray();
        $listGroup=Common::object2array($listGroup);
        $group = resetByKey($listGroup, "id");

        //节点信息
//        $whereNode['status'] = 1;
//        $whereNode['isdelete'] = 0;
        //对于非超级管理员用户只显示其拥有所有权限的节点
//        if (!ADMIN) {
//            $accessNode = DB::table("admin_access")
//                ->join("admin_role_user", "admin_role_user.role_id = admin_access.role_id")
//                ->where("admin_role_user.user_id", UID)
//                ->select(['admin_access.node_id'])->get()->toArray();
//            $whereNode['id'] = ["in", filterValue($accessNode, "node_id")];
//        }
        $node = DB::table("admin_node")
            ->where('status',1)
            ->where('is_delete',0)
            ->select(['id','pid','group_id','name','title','level','type'])
            ->get()->toArray();
        $accesses = DB::table("admin_access")->where("role_id", $roleId)->select()->get()->toArray();
        $accesses=Common::object2array($accesses);
        $accessesNode=$accesses?filterValue($accesses,'node_id'):[];
        //生成wdTree插件需要的数据格式
        $nodeTree = [];
        $node=Common::object2array($node);
        foreach ($node as $v) {
            $nodeTree[] = [
                "id" => $v['id'],
                "pid" => $v['pid'],
                "text" => $v['title'] . " (" . $v['name'] . ") " . (isset($group[$v['group_id']]) ? '<span style="color:red">[ ' . $group[$v['group_id']]['name'] . ' ]</span>' : ''),
                "value" => $v['id'] . "_" . $v['level'] . "_" . $v['pid'],
                "showcheck" => true,
                'checkstate' => in_array($v['id'], $accessesNode) ? 1 : 0,
                'hasChildren' => $v['type'] ? true : false,
                'isexpand' => true,
                'complete' => true,
            ];
        }

        //生成树
        return Common::listToTree($nodeTree, "id", "pid", "ChildNodes");
    }

    //获取角色下用户
    public function getUserByRole($roleId = 1)
    {
        $where['role_id'] = $roleId;
        $userModel = Loader::model('AdminUser');
        $userRoleModel = Loader::model('AdminRoleUser');
        $userIds = $userRoleModel->where($where)->select();
        $ids = [];
        foreach ($userIds as $key => $value) {
            $ids[] = $value['user_id'];
        }
        return $userList = $userModel->whereIn('id', $ids)->select();
    }

    //设置用户角色——默认组员
    public function setRole($userId, $roleId = 11)
    {
        $userRoleModel = Loader::model('AdminRoleUser');
        $userRoleModel->data([
            'user_id' => $userId,
            'role_id' => $roleId
        ]);
        return $userRoleModel->save();
    }
}