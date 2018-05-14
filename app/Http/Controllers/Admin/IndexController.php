<?php

namespace App\Http\Controllers\Admin;

use App\Services\Common;
use App\Services\Node;
use Illuminate\Support\Facades\Db;
use Illuminate\Support\Facades\Session;

class IndexController extends CommonController
{
    public function Index(){
        // 读取数据库模块列表生成菜单项
        $nodes = Node::getMenu($this->uid);
        // 节点转为树
        $nodes=Common::object2array($nodes);

        $treeNode =Common::listToTree($nodes,  'id', 'pid', '_child', '0');
        // 显示菜单项
        $menu = [];
        $groups_id = [];
        $currentModule=Common::getControllerActionName()['module'];
        foreach ($treeNode as $module) {
            if ($module['pid'] == 0 && strtoupper($module['name']) == strtoupper($currentModule)) {
                if (isset($module['_child'])) {
                    foreach ($module['_child'] as $controller) {
                        $group_id = $controller['group_id'];
                        array_push($groups_id, $group_id);
                        $menu[$group_id][] = $controller;
                    }
                }
            }
        }
        // 获取授权节点分组信息
        $groups_id = array_unique($groups_id);

        if (!$groups_id) {
            abort(403,"没有权限");
        }
        $groups = Db::table("admin_group")
            ->whereIn('id' , $groups_id)
            ->where('status',1)
            ->orderBy('sort','asc')
            ->orderBy('id','asc')
            ->select('id','name','icon','sort')->get();
        $data=[
        'groups'=>$groups,
        'menu'=>$menu,
        ];
        \Debugbar::info(Session::all());
        $data=Common::object2array($data);
        return view('admin.index',$data);
    }
}
