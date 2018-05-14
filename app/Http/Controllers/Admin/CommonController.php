<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\LoginLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
//use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Request;
use App\Services\Common;
use App\Model\CommonModel;

class CommonController extends Controller
{
    public $uid = 1;
    public $request = null;
    public $route = null;
    /**
     * @var int 是否删除标志，0-正常|1-删除|false-不包含该字段
     */
    protected static $isdelete = 0;

    /**
     * @var string 假删除字段
     */
    protected $fieldIsDelete = 'is_delete';

    /**
     * @var string 状态禁用、恢复字段
     */
    protected $fieldStatus = 'status';

    function __construct()
    {
        $this->request = Request::instance();
        $this->route = Common::getControllerActionName(false);
    }

    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

    /**
     * 通过模型查询
     * @param Model
     * @param array $map 过滤条件
     * @param string $field 查询的字段
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * @param boolean $paginate 是否开启分页
     */
    protected function datalistByModel($modelName, $map = [], $field = null, $sortBy = '', $asc = false, $paginate = true)
    {
        // 私有字段，指定特殊条件，查询时要删除
        $protectField = ['_relation', '_order_by', '_model', '_func', '_page'];
        // 通过过滤器指定模型
        if (isset($map['_model'])) {
            $modelName = $map['_model'];
        }
        $model = CommonModel::insModel($modelName);
        // 排序字段 默认为主键名
        $order = request('_order') ?: (empty($sortBy) ? $model->getPk() : $sortBy);
        // 设置关联预载入
        if (isset($map['_relation'])) {
            $model = $model->with($map['_relation']);
        }elseif($model->_relation){
            $model = $model->with($model->_relation);
        }
        // 接受 sort参数 0 表示倒序 非0都 表示正序
        $sort = null !== request('_sort') ? (request('_sort') == 'asc' ? 'asc' : 'desc') : ($asc ? 'asc' : 'desc');
        //$page = isset($map['_page']) ? intval($map['_page']) : 0;
        $listRows = request('numPerPage') ?: config("define.paginate.list_rows");
        //$offset = ($page - 1) * $listRows;
        // 删除设置属性的字段
        foreach ($protectField as $v) {
            unset($map[$v]);
        }
        //设置条件
        foreach ($map as $key => $value) {
            if (is_array($value)) {
                $model = $model->where($key, $value['ex'], $value['value']);
            } else {
                $model = $model->where($key, $value);
            }
        }
        if ($field) {
            $model = $model->select($field);
        }
        if ($paginate) {
            // 分页查询
            // 每页数据数量
            $list = $model
                //->parseWhereArray($map)
                ->orderBy($order, $sort)
                ->paginate($listRows);
            $data = [
                'list' => $list->toArray()['data'],
                "count" => $list->total(),
                //"page" => $list->appends($map)->links(),
                "page" => $list->appends($this->request->input())->links(),
                'numPerPage' => $listRows,
            ];
        } else {
            // 不开启分页查询
            $list = $model
                //->parseWhereArray($map)
                ->orderBy($order, $sort)
                ->get()->toArray();
            $data = [
                'list' => $list,
                "count" => count($list),
                "page" => '',
                'numPerPage' => 0,
            ];
        }
        return $data;
    }

    /**
     * 通过数据库查询
     * @param Db
     * @param array $map 过滤条件
     * @param string $field 查询的字段
     * @param string $sortBy 排序
     * @param boolean $asc 是否正序
     * @param boolean $paginate 是否开启分页
     */
    /*
    protected function datalistByDb($db, $map = [], $field = null, $sortBy = '', $asc = false, $paginate = true)
    {
        // 私有字段，指定特殊条件，查询时要删除
        $protectField = [ '_order_by', '_func', '_page'];
        // 排序字段 默认为主键名
        $db=DB::table($db);
        $pk='';
        $order = request('_order') ?: (empty($sortBy) ? $pk : $sortBy);
        // 接受 sort参数 0 表示倒序 非0都 表示正序
        $sort = null !== request('_sort') ? (request('_sort') == 'asc' ? 'asc' : 'desc') : ($asc ? 'asc' : 'desc');
        //$page = isset($map['_page']) ? intval($map['_page']) : 0;
        $listRows = request('numPerPage') ?: config("define.paginate.list_rows");
        //$offset = ($page - 1) * $listRows;
        // 删除设置属性的字段
        foreach ($protectField as $v) {
            unset($map[$v]);
        }
        if ($field) {
            $db = $db->select($field);
        }
        if ($paginate) {
            // 分页查询
            // 每页数据数量
            $list = $db
                ->parseWhereArray($map)
                ->orderBy($order, $sort)
                ->paginate($listRows);
            $data = [
                'list' => $list->toArray()['data'],
                "count" => $list->total(),
                //"page" => $list->appends($map)->links(),
                "page" => $list->appends($this->request->input())->links(),
                'numPerPage' => $listRows,
            ];
        } else {
            // 不开启分页查询
            $list = $db
                ->parseWhereArray($map)
                ->orderBy($order, $sort)
                ->get()->toArray();
            $data = [
                'list' => $list,
                "count" => count($list),
                "page" => '',
                'numPerPage' => 0,
            ];
        }
        return $data;
    }
*/
    /**
     * 自动搜索查询字段,给模型字段过滤
     * $param = ['sort'=>['ex'=>'=','value'=>3]]
     */
    protected function search($model, $param = [])
    {
        $map = [];
        //$map['_page'] = Request::get('page');
        $table = null;
        $modelClass = $model = CommonModel::insModel($model);
        if ($modelClass->getTable()) {
            $table = $modelClass->getTable();
        } else {
            $table = strtolower($model) . 's';
        }
        $columns = Schema::getColumnListing($table);
        $param = array_merge($this->request->input(), $param);
        //过滤字段

        foreach ($param as $key => $val) {
            if (isset($val['ex']) && isset($val['value']) && in_array($key, $columns)) {
                //处理like查询条件
                if ($val['ex'] == 'like') {
                    $val['value'] = "%{$val['value']}%";
                }
                $map[$key] = $val;
            }
        }
        return $map;
    }

    public function index()
    {
        $map = $this->search($this->route['controller']);
        $data = $this->datalistByModel($this->route['controller'], $map);
        return view("admin.{$this->route['controller']}.index", $data);
    }


    /**
     * 添加
     * @return mixed
     */

    public function add()
    {
        $controller = $this->route['controller'];
        $ret = false;
        if ($this->request->ajax()) {
            $data = $this->request->except(['id']);
//            dd(new \App\Http\Requests\GroupRequest());

            // 验证
            $requestClass = '\App\Http\Requests\\' . $controller . 'Request';
            if (class_exists($requestClass)) {
                $validatorRequest = new $requestClass();
                $validator = validator($data, $validatorRequest->customRules['add'], $validatorRequest->messages);
                if ($validator->fails()) {
                    return ajaxReturnAdvError($validator->errors()->first());
                }
            }

            // 写入数据
            if (CommonModel::modelExists($controller)) {
                //使用模型写入，可以在模型中定义更高级的操作
                $model = CommonModel::insModel($controller);
                if ($model->fill($data)) {
                    $ret = $model->save();
                }
            } else {
                // 简单的直接使用db写入
                try {
                    $ret = DB::table('admin_' . $controller)->insert($data);
                } catch (QueryException $e) {
                    return ajaxReturnAdvError($e->getMessage());
                }
            }
            if ($ret) {
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            // 添加
            return view("admin.{$this->route['controller']}.add");
        }
    }

    /**
     * 编辑
     * @return mixed
     */
    public function edit()
    {
        $controller = $this->route['controller'];
        $ret = false;
        $id = $this->request->input('id');
        if (!$id) {
            return abort(403, '参数错误');
        }
        if ($this->request->ajax()) {
            $data = $this->request->except(['id']);
            // 验证
            $requestClass = '\App\Http\Requests\\' . $controller . 'Request';
            if (class_exists($requestClass)) {
                $validatorRequest = new $requestClass();
                $validator = validator($data, $validatorRequest->customRules['edit'], $validatorRequest->messages);
                if ($validator->fails()) {
                    return ajaxReturnAdvError($validator->errors()->first());
                }
            }
            // 更新数据
            if (CommonModel::modelExists($controller)) {
                //使用模型更新，可以在模型中定义更高级的操作
                $model = CommonModel::insModel($controller);
                $ret = $model->where('id', $id)->update($data);
            } else {
                // 简单的直接使用db更新
                $data['update_time']=date('Y-m-d H:i:s',time());
                try {
                    $ret = DB::table('admin_' . $controller)->where('id', $id)->update($data);
                } catch (QueryException $e) {
                    return ajaxReturnAdvError($e->getMessage());
                }
            }
            if ($ret) {
                return ajaxReturnAdv('保存成功');
            } else {
                return ajaxReturnAdvError('保存失败');
            }
        } else {
            $vo = DB::table('admin_' . $controller)->find($id);
            $vo = Common::object2array($vo);
            if (!$vo) {
                abort(403, '该记录不存在');
            }
            return view("admin.{$this->route['controller']}.edit", ['vo' => $vo]);
        }
    }

    public function sedit()
    {
        $this->edit();
    }

    /**
     * 默认删除操作
     */
    public function delete()
    {
        return $this->updateField($this->route['controller'], $this->fieldIsDelete, 1, "移动到回收站成功");
    }

    public function sdelete()
    {
        return $this->delete();
    }

    /**
     * 永久删除
     */
    public function deleteForever()
    {
        $model = CommonModel::insModel($this->route['controller']);
        $pk = $model->getPk();
        $ids = $this->request->input();
        try {
            $model->whereIn($pk, $ids)->delete();
        } catch (QueryException $e) {
            return ajaxReturnAdvError('删除失败：' . $e->getMessage());
        }
        return ajaxReturnAdv("删除成功");
    }


    /**
     * 从回收站恢复
     */
    public function recycle()
    {
        return $this->updateField($this->route['controller'], $this->fieldIsDelete, 0, "恢复成功");
    }

    /**
     * 默认禁用操作
     */
    public function forbid()
    {
        return $this->updateField($this->route['controller'], $this->fieldStatus, 0, "禁用成功");
    }


    /**
     * 默认恢复操作
     */
    public function resume()
    {
        return $this->updateField($this->route['controller'], $this->fieldStatus, 1, "恢复成功");
    }

    /**
     * 默认更新字段方法
     *
     * @param string $field 更新的字段
     * @param string|int $value 更新的值
     * @param string $msg 操作成功提示信息
     * @param string $pk 主键，默认为主键
     * @param string $input 接收参数，默认为主键
     */
    protected function updateField($model, $field, $value, $msg = "操作成功", $pk = "", $input = "")
    {

        $model = CommonModel::insModel($model);
        if (!$pk) {
            $pk = $model->getPk();
        }
        if (!$input) {
            $input = $model->getPk();
        }
        $ids = $this->request->input($input);
        if ($ids) {
            if (!is_array($ids)) {
                $ids = [$ids];
            }
            if (false === $model->whereIn($pk, $ids)->update([$field => $value])) {
                return ajaxReturnAdvError('操作失败');
            }
            return ajaxReturnAdv($msg, '');
        } else {
            return ajaxReturnAdvError('参数错误');
        }
    }

    /**
     * 保存排序
     */
    public function saveOrder()
    {
        $param = $this->request->input();
        if (!isset($param['sort'])) {
            return ajaxReturnAdvError('缺少参数');
        }
        $model = CommonModel::insModel($this->route['controller']);
        foreach ($param['sort'] as $id => $sort) {
            $model->where('id', $id)->update(['sort' => $sort]);
        }
        return ajaxReturnAdv('保存排序成功', '');
    }
}
