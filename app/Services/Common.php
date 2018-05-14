<?php

namespace App\Services;
//use Illuminate\Support\Facades\Request;
//use Illuminate\Support\Facades\URL;

class   Common
{
    public static function getControllerActionName($isLower = 1)
    {
        $actions = explode('\\', \Route::current()->getActionName());
        //或$actions=explode('\\', \Route::currentRouteAction());
        $modelName = $actions[count($actions) - 2] == 'Controllers' ? null : $actions[count($actions) - 2];
        $func = explode('@', $actions[count($actions) - 1]);
        $data['controller'] = substr($func[0], 0, -10);
        $data['action'] = $func[1];
        $data['module'] = $modelName;
        if ($isLower) {
            $data['controller'] = strtolower($data['controller']);
            $data['action'] = strtolower($data['action']);
            $data['module'] = strtolower($data['module']);
        }
        return $data;
    }

    /**
     * @param array $list 要转换的结果集
     * @param string $pid parent标记字段
     * @param string $child level标记字段
     */
    public static function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        //创建Tree
        $tree = array();
        if (is_array($list)) {
            //创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] = &$list[$key];
            }
            foreach ($list as $key => $value) {
                //判断是否存在parent
                $parantId = $value[$pid];
                if ($root == $parantId) {
                    $tree[] = &$list[$key];
                } else {
                    if (isset($refer[$parantId])) {
                        $parent = &$refer[$parantId];
                        $parent[$child][] = &$list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    public static function object2array(&$object)
    {
        if (!empty($object)) {
            $object = json_decode(json_encode($object), true);
            return $object;
        }

    }

    /**
     * 统一密码加密方式，如需变动直接修改此处
     * @param $password
     * @return string
     */
    public static function passwordHash($password)
    {
        return hash("md5", trim($password));
    }

}