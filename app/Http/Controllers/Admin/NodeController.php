<?php

namespace App\Http\Controllers\Admin;

use App\Services\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Model\CommonModel;
class NodeController extends CommonController
{
    /**
     * 首页
     */
    public function index()
    {
        if ($this->request->ajax()) {
            try {
                $moduleId = $this->request->input('module_id');
                $groupId = $this->request->input('group_id');
                if ($this->request->input('type') == 'group') {
                    // 查询分组
                    // 查询二级节点下分组信息
                    $node = DB::table('admin_node')
                        ->where("is_delete", 0)
                        ->where("level", 2)
                        ->where("pid", $moduleId)
                        ->select(['group_id'])->get()->toArray();
                    $node = Common::object2array($node);
                    if (!$node) {
                        return ajaxReturnAdvError('该模块下没有任何节点');
                    }
                    // 分组下菜单个数
                    $groupId = [];
                    foreach ($node as $vo) {
                        if (isset($groupId[$vo['group_id']])) {
                            $groupId[$vo['group_id']] += 1;
                        } else {
                            $groupId[$vo['group_id']] = 1;
                        }
                    }

                    // 分组信息
                    $groupList = DB::table('admin_group')
                        ->orderBy('sort', 'asc')
                        ->whereIn('id', array_keys($groupId))
                        ->where('is_delete', 0)
                        ->select(['id', 'name', 'icon', 'sort', 'status'])
                        ->get()->toArray();
                    $groupList = Common::object2array($groupList);
                    return ajaxReturn(['count' => $groupId, 'list' => $groupList]);
                } else {
                    // 查询节点
                    $first = DB::table('admin_node')
                        ->where('is_delete', 0)
                        ->where('level', '>', 2);
                    $list = DB::table('admin_node')
                        ->union($first)
                        ->where("is_delete", 0)
                        ->where("level", 2)
                        ->where("pid", $moduleId)
                        ->where("group_id", $groupId)
                        ->select()->get()->toArray();
                    $list = Common::object2array($list);
                    // 重新组装节点
                    $list2 = [];
                    foreach ($list as $vo) {
                        $list2[] = ['name' => '<span class="c-warning">[ ' . ($vo['level'] == 1 ? '模块' : ($vo['type'] ? '控制器' : '方法')) . ' ]</span> '
                            . $vo['title'] . " (" . $vo['name'] . ") "
                            . ' <a></a><span class="c-secondary">[ 层级：' . $vo['level'] . ' ]</span> '
                            . showStatus($vo['status'], $vo['id'])
                            . ' <a class="label label-primary radius J_add" data-id="' . $vo['id'] . '" href="javascript:;" title="添加子节点">添加</a>', 'id' => $vo['id'], 'pid' => $vo['pid']];
                    }
                    $node = Common::listToTree($list2, 'id', 'pid', 'children', $moduleId);

                    return ajaxReturn(['list' => $node]);
                }
            } catch (\Exception $e) {
                return ajaxReturnError($e->getMessage());
            }
        } else {
            $modules = DB::table('admin_node')
                ->orderBy('sort', 'asc')
                ->where('pid', 0)
                ->where('is_delete', 0)
                ->select()->get()->toArray();
            $modules = Common::object2array($modules);
            $data = [
                'modules' => $modules,
                'node' => '',
            ];
            return view('admin.node.index', $data);
        }
    }


    public function add()
    {
        $ret = false;
        if ($this->request->ajax()) {
            $data = $this->request->except(['id']);
            // 验证
            $requestClass = '\App\Http\Requests\NodeRequest';
            if (class_exists($requestClass)) {
                $validatorRequest = new $requestClass();
                $validator = validator($data, $validatorRequest->customRules['add'], $validatorRequest->messages);
                if ($validator->fails()) {
                    return ajaxReturnAdvError($validator->errors()->first());
                }
            }
            // 写入数据
            //使用模型写入，可以在模型中定义更高级的操作
            $model = CommonModel::insModel('Node');
            if ($model->fill($data)) {
                $ret = $model->save();
            }
            if ($ret) {
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            // 添加
            //分组
            $groupList = DB::table('admin_group')
                ->where('is_delete', 0)
                ->where('status', 1)
                ->select()->get()->toArray();
            $groupList = Common::object2array($groupList);
            //父节点和层级
            $node = DB::table("admin_node")
                ->where("id", $this->request->input('pid',0))
                ->select(['id', 'level'])->get()->toArray();
            $node = Common::object2array($node);
            $vo['pid'] = isset($node['id'])?$node['id']:0;
            $vo['level'] = intval($node['level']) + 1;
            $data = [
                'group_list' => $groupList,
                'vo' => $vo
            ];
            return view("admin.{$this->route['controller']}.add", $data);
        }
    }

    /**
     * 编辑
     * @return mixed
     */
    public function edit()
    {
        $requestClass = '\App\Http\Requests\NodeRequest';
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
            $model = CommonModel::insModel('Node');
            $ret = $model->where('id', $id)->update($data);
            if ($ret) {
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            $vo = DB::table('admin_node')->find($id);
            $vo = Common::object2array($vo);
            if (!$vo) {
                abort(403, '该记录不存在');
            }
            $groupList = DB::table('admin_group')
                ->where('is_delete', 0)
                ->where('status', 1)
                ->select()->get()->toArray();
            $groupList = Common::object2array($groupList);
            //父节点和层级
            $node = DB::table("admin_node")
                ->where("id", $this->request->input('pid'))
                ->select(['id', 'level'])->get()->toArray();
            $node = Common::object2array($node);
            $vo['pid'] = $node['id'];
            $vo['level'] = intval($node['level']) + 1;
            $data = [
                'group_list' => $groupList,
                'vo' => $vo
            ];
            return view("admin.{$this->route['controller']}.edit", $data);
        }
    }
}
