<?php
/**
 * Created by PhpStorm.
 * User: pla
 * Date: 2018/1/23
 * Time: 14:58
 */

namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class Rbac
{


    function __construct()
    {

    }

    /**
     * 认证方法
     */
    public static function authenticate($account, $model = '')
    {
        if (!$model) {
            $model = config('rbac.user_auth_model');
        }
        //使用给定的Map进行认证
        return Db::table($model)->where('status', 1)->where('account', $account)->first();
    }

    /**
     * 用于检测用户权限的方法,并保存到Session中
     * @param null $authId
     */
    public static function saveAccessList($authId = null)
    {
        if (null === $authId) {
            $authId = Session::get(config('rbac.user_auth_key'));
        }
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        if (config('rbac.user_auth_type') != 2 && Session::get(config('rbac.admin_auth_key'))) {
            Session::put('_access_list', self::getAccessList($authId));
        }

        return;
    }

    /**
     * 检查当前操作是否需要认证
     * @return bool
     */
    public static function checkAccess()
    {
        // 如果项目要求认证，并且当前控制器需要认证，则进行权限认证
        //dd(self::$route);
        $route = Common::getControllerActionName();
        if (config('rbac.user_auth_on')) {
            $controller = [];
            $action = [];
            if ('' != config('rbac.require_auth_controller')) {
                // 需要认证的模块
                $controller['yes'] = explode(',', strtoupper(config('rbac.require_auth_controller')));
            } else {
                // 无需认证的模块
                $controller['no'] = explode(',', strtoupper(config('rbac.not_auth_controller')));
            }
            // 检查当前控制器是否需要认证
            if (
                (isset($controller['no']) && !in_array(strtoupper($route['controller']), $controller['no'])) ||
                (isset($controller['yes']) && in_array(strtoupper($route['controller']), $controller['yes']))
            ) {
                if (config('rbac.require_auth_action')) {
                    // 需要认证的操作
                    $action['yes'] = explode(',', strtoupper(config('rbac.require_auth_action')));
                } else {
                    // 无需认证的操作
                    $action['no'] = explode(',', strtoupper(config('rbac.not_auth_action')));
                }
                // 检查当前操作是否需要认证
                if (
                    (isset($action['no']) && !in_array(strtoupper($route['action']), $action['no'])) ||
                    (isset($action['yes']) && in_array(strtoupper($route['action']), $action['yes']))
                ) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * 登录检查
     * @return bool
     */
    public static function checkLogin()
    {
        //检查当前操作是否需要认证
        if (self::checkAccess()) {
            //检查认证识别号
            if (Session::has(config('rbac.user_auth_key'))) {
                if (Session::get('rbac.guest_auth_on')) {
                    // 开启游客授权访问
                    if (Session::has('_access_list'))
                        // 保存游客权限
                        self::saveAccessList(config('rbac.guest_auth_id'));
                } else {
                    // 禁止游客访问
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 权限认证的过滤器方法
     * @param null $actionName
     * @param null $controllerName
     * @param null $moduleName
     * @return bool
     */
    public static function AccessCheck($actionName = null, $controllerName = null, $moduleName = null)
    {
        $route = Common::getControllerActionName();
        //检查是否需要认证
        if (self::checkAccess()) {
            //存在认证识别号，则进行进一步的访问决策
            if (!Session::has(config('rbac.admin_auth_key'))) {
                if (null === $moduleName) {
                    $moduleName = $route['module'];
                }
                if (null === $controllerName) {
                    $controllerName = $route['controller'];
                }
                if (null === $actionName) {
                    $actionName = $route['action'];
                }
                $module = strtoupper($moduleName);
                $controller = strtoupper($controllerName);
                $action = strtoupper($actionName);
                $common = strtoupper('rbac.common_auth_name');

                if (2 == config('rbac.user_auth_type')) {
                    //加强验证和即时验证模式 更加安全 后台权限修改可以即时生效
                    $userId = Session::get(config('rbac.user_auth_key'));
                    // 将权限缓存5分钟
                    $cacheKey = 'admin_user_auth_' . $userId;
                    if (!$accessList = Cache::get($cacheKey)) {
                        $accessList = self::getAccessList($userId);
                        Cache::set($cacheKey, $accessList, 300);
                    }
                } else {
                    //登录验证模式，比较登录后保存的权限访问列表
                    $accessList = Session::get('_access_list');
                }
                //验证全名或者包含common控制器或方法的名称
                $node = explode('.', $controller);
                array_unshift($node, $module);
                array_push($node, $action);
                //检查当前节点是否直接授权
                if (self::keyExist($accessList, $node)) {
                    return true;
                }

                //检查是否有公共节点授权
                for ($i = 1; $i < count($node) - 1; $i++) {
                    $tmp = $node;
                    $tmp[$i] = $common;
                    if (self::keyExist($accessList, $tmp)) {
                        return true;
                    }
                }
                return false;
            } else {
                //管理员无需认证
                return true;
            }
        }

        return true;
    }

    /**
     * 判断多维数组是否存在$key中的key
     * @param $multi
     * @param $key
     * @return bool
     */
    private static function keyExist($multi, $key)
    {
        $tmp = $multi;
        while ($k = array_shift($key)) {
            if (isset($tmp[$k])) {
                $tmp = $tmp[$k];
            } else {
                return false;
            }
        }

        return true;
    }

    /**
     * 取得当前认证号的所有权限列表
     * @param $authId
     * @return array
     */
    public static function getAccessList($authId)
    {
        // 表前缀
        $table = [
            'role' => config('rbac.role_table'),
            'user' => config('rbac.user_table'),
            'access' => config('rbac.access_table'),
            'node' => config('rbac.node_table'),
        ];
        $sql = "SELECT node.id,node.name,node.pid FROM " .
            $table['role'] . " AS role," .
            $table['user'] . " AS user," .
            $table['access'] . " AS access ," .
            $table['node'] . " AS node " .
            "WHERE " .
            "user.user_id='{$authId}' " .
            "AND user.role_id=role.id " .
            "AND access.role_id=role.id " .
            "AND role.status=1 " .
            "AND access.node_id=node.id " .
            "AND node.status=1 ";
        $apps = Db::select($sql);
        //转化为树
        $apps = Common::object2array($apps);
        $tree = Common::listToTree($apps, 'id', 'pid', '_child', '0');
        //递归生成权限树
        $ret = self::treeToMultiArray($tree, "name", "id", "_child");

        return $ret;
    }


    /**
     * 将树递归成多维数组
     * @param array $tree 树
     * @param string $key 放入多维数组里的键名
     * @param string|array $key_default 默认值，如果是数组[VALUE]，则为当前数组子项的键名，如果是其他就是传入的值
     * @param string $key_child 子节点键名
     * @return array
     */
    private static function treeToMultiArray($tree, $key = "name", $key_default = "id", $key_child = "_child")
    {
        $return = [];
        if (is_array($tree)) {
            foreach ($tree as $v) {
                // 默认值
                if (isset($v[$key_child])) {
                    $default = self::treeToMultiArray($v[$key_child], $key, $key_default, $key_child);
                } else {
                    $default = $v[$key_default];
                }

                // 存在高阶节点，转为多维数组 (one.two/index 或 one/index 类型高阶节点)
                $nodes = explode("/", strtoupper(str_replace(".", "/", $v[$key])));
                $return = array_merge_multi($return, self::arrayOneToMulti($nodes, count($nodes), $default));
            }
        }

        return $return;
    }

    /**
     * 一维数组转多维数组
     * @param array $source 原一维数组
     * @param int $length 原一维数组长度
     * @param string|array $default 多维数组默认值
     * @param int $i 开始索引
     * @param array $target 转化为的目标数组
     * @return array
     */
    private static function arrayOneToMulti($source, $length, $default = '', $i = 0, $target = [])
    {
        if ($i == $length - 1) {
            $target[$source[$i]] = $default;
        } else {
            $target[$source[$i]] = self::arrayOneToMulti($source, $length, $default, $i + 1, $target);
        }

        return $target;
    }
}