<?php
use app\Services\Common;
$param=isset($param) ? $param : [];
$menu = isset($menu) ? (is_array($menu) ? $menu : explode(',', $menu)) : ['add', 'forbid', 'resume', 'delete', 'recyclebin', 'addimage'];
$titleArr = isset($title) ? (is_array($title) ? $title : explode(',', $title)) : [];
$urlArr = isset($url) ? (is_array($url) ? $url : explode(',', $url)) : [];
$parseStr = '';
$action = app\Services\Common::getControllerActionName(false);
$controllerClass = 'App\Http\Controllers\Admin\\' . $action['controller'] . 'Controller';
$route=Common::getControllerActionName();
foreach ($menu as $k => $m) {
    //$m = strtolower($m);
    $url = isset($urlArr[$k]) && $urlArr[$k] ? $urlArr[$k] : (substr($m, 0, 1) == 's' ? substr($m, 1) : $m);
    $urls = explode(":", $url);
    if (App\Services\Rbac::AccessCheck($route['action'],$route['controller'],$route['module']) && Route::getRoutes()->getByAction($controllerClass . '@' . $m)) {
        switch ($m) {
            case 'add':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '添加';
                $parseStr .= '<a class="btn btn-primary radius mr-5" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@add', $param) . '\')"><i class="Hui-iconfont">&#xe600;</i> ' . $title . '</a>';
                break;
            case 'forbid':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '禁用';
                $parseStr .= '<a href="javascript:;" onclick="forbid_all(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@forbid', $param) . '\')" class="btn btn-warning radius mr-5"><i class="Hui-iconfont">&#xe631;</i> ' . $title . '</a>';
                break;
            case 'resume':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '恢复';
                $parseStr .= '<a href="javascript:;" onclick="resume_all(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@resume', $param) . '\')" class="btn btn-success radius mr-5"><i class="Hui-iconfont">&#xe615;</i> ' . $title . '</a>';
                break;
            case 'delete':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '删除';
                $parseStr .= '<a href="javascript:;" onclick="del_all(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@delete', $param) . '\')" class="btn btn-danger radius mr-5"><i class="Hui-iconfont">&#xe6e2;</i> ' . $title . '</a>';
                break;
            case 'recyclebin':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '回收站';
                $parseStr .= '<a href="javascript:;" onclick="open_window(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@recyclebin', $param) . '\')" class="btn btn-secondary radius mr-5"><i class="Hui-iconfont">&#xe6b9;</i> ' . $title . '</a>';
                break;
            case 'recycle':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '还原';
                $parseStr .= '<a class="btn btn-success radius mr-5" href="javascript:;" onclick="recycle_all(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@recycle', $param) . '\')"><i class="Hui-iconfont">&#xe610;</i> ' . $title . '</a>';
                break;
            case 'deleteForever':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '彻底删除';
                $parseStr .= '<a href="javascript:;" onclick="del_forever_all(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@deleteForever', $param) . '\')" class="btn btn-danger radius mr-5"><i class="Hui-iconfont">&#xe6e2;</i> ' . $title . '</a>';
                break;
            case 'clear':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '清空回收站';
                $parseStr .= '<a href="javascript:;" onclick="clear_recyclebin(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@clear', $param) . '\')" class="btn btn-danger radius mr-5"><i class="Hui-iconfont">&#xe6e2;</i> ' . $title . '</a>';
                break;
            case 'ssaveOrder':
            case 'saveOrder':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '保存排序';
                $parseStr .= '<a href="javascript:;" onclick="saveOrder()" class="btn btn-primary radius mr-5"><i class="Hui-iconfont">&#xe632;</i> ' . $title . '</a>';
                break;
            case 'edit':
            case 'sedit':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '编辑';
                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@edit', $param) . '\')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">&#xe6df;</i></a>';
                break;
            case 'sdelete':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '删除';
                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="del(this,\'' . $param['id'] . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@delete', $param) . '\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>';
                break;
            case 'srecycle':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '还原';
                $parseStr .= ' <a href="javascript:;" onclick="recycle(this,\'' . $param['id'] . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@recycle', $param) . '\')" class="label label-success radius ml-5">' . $title . '</a>';
                break;
            case 'sdeleteForever':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '彻底删除';
                $parseStr .= ' <a href="javascript:;" onclick="del_forever(this,\'' . $param['id'] . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@deleteForever', $param) . '\')" class="label label-danger radius ml-5">' . $title . '</a>';
                break;
            case 'addimage':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '添加图片';
                $parseStr .= '<a class="btn btn-primary radius mr-5" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@addimage', $param) . '\')"><i class="Hui-iconfont">&#xe600;</i> ' . $title . '</a>';
                break;
            case 'user':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '用户列表';
                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@user', $param) . '\')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">用户列表</i></a>';
                break;
            case 'access':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '授权';
                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@access', $param) . '\')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">授权</i></a>';
                break;
            case 'password':
                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '用户列表';
                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="layer_open(\'' . $title . '\',\'' . action($action['module'] . '\\' . $action['controller'] . 'Controller@password', $param) . '\')" style="text-decoration:none" class="ml-5"><i class="Hui-iconfont">修改密码</i></a>';
                break;

            default:
                // 默认为小菜单
//                $title = isset($titleArr[$k]) && $titleArr[$k] ? $titleArr[$k] : '菜单';
//                $class = isset($tag['class']) ? $tag['class'] : 'label-primary';
//                $parseStr .= ' <a title="' . $title . '" href="javascript:;" onclick="layer_open(\'' . $title . '\',\''.action("{$action['controller']}Controller@index",$param).'\')" class="label radius ml-5 ' . $class . '">' . $title . '</a>';
        }
    }
}
echo $parseStr;