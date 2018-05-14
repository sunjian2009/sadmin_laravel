<?php
/**
 * Created by PhpStorm.
 * User: pla
 * Date: 2018/1/23
 * Time: 21:47
 */

namespace App\Services;
use Illuminate\Support\Facades\DB;

class Node
{
    /**
     * 首页列表生成菜单项
     */
    public static  function getMenu($uid)
    {
        if ($uid==1) {
            $nodes = Db::table("admin_node")
                ->where('status',1)
                ->where('group_id', '>', 0)
                ->select('id','pid','name','group_id','title','type')->get();
        } else {
            $sql = "SELECT node.id,node.name,node.pid,node.group_id,node.title,node.type from "
                . "admin_role AS role,"
                . "admin_role_user AS user,"
                . "admin_access AS access ,"
                . "admin_node AS node "
                . "WHERE user.user_id='" . $uid . "' "
                . "AND user.role_id=role.id "
                . "AND access.role_id=role.id "
                . "AND role.status=1 "
                . "AND access.node_id=node.id "
                . "AND node.status=1 "
                . "AND node.group_id > 0 "
                . "ORDER BY node.sort ASC";
            $nodes = Db::select($sql)->get()->toArray();
        }

        return $nodes;
    }
}