<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use app\Services\Common;

/**
 * 框架内部默认ajax返回
 * @param string $msg 提示信息
 * @param string $redirect 重定向类型 current|parent|''
 * @param string $alert 父层弹框信息
 * @param bool $close 是否关闭当前层
 * @param string $url 重定向地址
 * @param string $data 附加数据
 * @param int $code 错误码
 * @param array $extend 扩展数据
 */
function ajaxReturnAdv($msg = '操作成功', $redirect = 'parent', $alert = '', $close = false, $url = '', $data = '', $code = 0, $extend = [])
{
    $extend['opt'] = [
        'alert' => $alert,
        'close' => $close,
        'redirect' => $redirect,
        'url' => $url,
    ];
    return ajaxReturn($data, $msg, $code, $extend);
}

/**
 * ajax数据返回，规范格式
 * @param array $data 返回的数据，默认空数组
 * @param string $msg 信息
 * @param int $code 错误码，0-未出现错误|其他出现错误
 * @param array $extend 扩展数据
 */
function ajaxReturn($data = [], $msg = "", $code = 0, $extend = [])
{
    $ret = ["code" => $code, "msg" => $msg, "data" => $data];
    $ret = array_merge($ret, $extend);
    return response()->json($ret);
}

/**
 * 返回标准错误json信息
 */
function ajaxReturnError($msg = "出现错误", $code = 1, $data = [], $extend = [])
{
    return ajaxReturn($data, $msg, $code, $extend);
}

/**
 * 返回错误json信息
 */
function ajaxReturnAdvError($msg = '', $code = 1, $redirect = '', $alert = '', $close = false, $url = '', $data = '', $extend = [])
{
    return ajaxReturnAdv($msg, $alert, $close, $redirect, $url, $data, $code, $extend);
}


/**
 * 表格排序筛选
 * @param string $name 单元格名称
 * @param string $field 排序字段
 * @return string
 */
function sortBy($name, $field = '')
{
    $action = Common::getControllerActionName(false);
    //$action['module']=lcfirst($action['module']);
    //$action['controller']=lcfirst($action['controller']);
    $sort = request('_sort');
    $param = Request::input();
    $param['_sort'] = ($sort == 'asc' ? 'desc' : 'asc');
    $param['_order'] = $field;
    //dd($param);
    $url = action("{$action['module']}" . '\\' . "{$action['controller']}Controller@{$action['action']}", $param);
    return request('_order') == $field ?
        "<a href='{$url}' title='点击排序' class='sorting-box sorting-{$sort}'>{$name}</a>" :
        "<a href='{$url}' title='点击排序' class='sorting-box sorting'>{$name}</a>";
}

/**
 * 用于高亮搜索关键词
 * @param string $string 原文本
 * @param string $needle 关键词
 * @param string $class span标签class名
 * @return mixed
 */
function highLight($string, $needle = '', $class = 'c-red')
{
    return $needle !== '' ? str_replace($needle, "<span class='{$class}'>" . $needle . "</span>", $string) : $string;
}

/**
 * 用于显示状态操作按钮
 * @param int $status 0|1|-1状态
 * @param int $id 对象id
 * @param string $field 字段，默认id
 * @param string $controller 默认当前控制器
 * @return string
 */
function showStatus($status, $id, $field = 'id', $controller = '')
{
    $action = Common::getControllerActionName(false);
    $controller = $action['controller'];
    switch ($status) {
        // 恢复
        case 0:
            $ret = '<a href="javascript:;" onclick="ajax_req(\'' . action("{$action['module']}" . '\\' . "{$action['controller']}Controller@resume", [$field => $id]) . '\',{},change_status,[this,\'resume\'])" class="label label-success radius" title="点击恢复">恢复</a>';
            break;
        // 禁用
        case 1:
            $ret = '<a href="javascript:;" onclick="ajax_req(\'' . action("{$action['module']}" . '\\' . "{$action['controller']}Controller@forbid", [$field => $id]) . '\',{},change_status,[this,\'forbid\'])" class="label label-warning radius" title="点击禁用">禁用</a>';
            break;
        // 还原
        case -1:
            $ret = '<a href="javascript:;" onclick="ajax_req(\'' . action("{$action['module']}" . '\\' . "{$action['controller']}Controller@recycle", [$field => $id]) . '\')" class="label label-secondary radius" title="点击还原">还原</a>';
            break;
    }

    return $ret;
}

/**
 * 显示状态
 * @param int $status 0|1|-1
 * @param bool $imageShow true只显示图标|false只显示文字
 * @return string
 */
function getStatus($status, $imageShow = true)
{
    switch ($status) {
        case 0:
            $showText = '禁用';
            $showImg = '<i class="Hui-iconfont c-warning status" title="禁用">&#xe631;</i>';
            break;
        case -1:
            $showText = '删除';
            $showImg = '<i class="Hui-iconfont c-danger status" title="删除">&#xe6e2;</i>';
            break;
        case 1:
        default:
            $showText = '正常';
            $showImg = '<i class="Hui-iconfont c-success status" title="正常">&#xe615;</i>';
    }

    return ($imageShow === true) ? $showImg : $showText;
}


/**
 * 从二维数组中取出自己要的KEY值
 * @param  array $arrData
 * @param string $key
 * @param $im true 返回逗号分隔
 * @return array
 */
function filterValue($arrData, $key, $im = false)
{
    $re = [];
    foreach ($arrData as $k => $v) {
        if (isset($v[$key])) {
            $re[] = $v[$key];
        }
    }
    if (!empty($re)) {
        $re = array_flip(array_flip($re));
        sort($re);
    }

    return $im ? implode(',', $re) : $re;
}

/**
 * 重设键，转为array(key=>array())
 * @param array $arr
 * @param string $key
 * @return array
 */
function resetByKey($arr, $key)
{
    $re = [];
    foreach ($arr as $v) {
        $re[$v[$key]] = $v;
    }

    return $re;
}