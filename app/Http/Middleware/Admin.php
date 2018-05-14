<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Common;
use App\Services\Rbac;
use App\Services\User;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Admin
{
    /**
     * @var array 黑名单方法，禁止访问某些方法
     */
    protected static $blacklist = [];

    /**
     * @var array 白名单方法，如果设置会覆盖黑名单方法，只允许白名单方法能正常访问
     */
    protected static $allowList = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public $route = null;

    function __construct()
    {
        $this->route = Common::getControllerActionName();
    }

    public function handle($request, Closure $next)
    {
        // 白名单/黑名单方法
        if ($this::$allowList && !in_array($this->route['action'], $this::$allowList)) {
            abort(404, 'method not exists:' . $this->route['controller'] . '->' . $this->route['action']);
        } elseif ($this::$blacklist && in_array($this->route['action'], $this::$blacklist)) {
            abort(404, 'method not exists:' . $this->route['controller'] . '->' . $this->route['action']);
        }

        // 用户ID
        defined('UID') or define('UID', Session::get(config('rbac.user_auth_key')));
        // 是否是管理员
        defined('ADMIN') or define('ADMIN', true === Session::get(config('rbac.admin_auth_key')));
        $notAuthController = config('rbac.not_auth_controller');
        // 检查认证识别号
        if (null === UID && !in_array($this->route['controller'], explode(',', $notAuthController))) {
            return $this->notLogin();
        } else {
            $this->auth();
        }
        return $next($request);
    }

    /**
     * 未登录处理
     */
    protected function notLogin()
    {
        // 登录框地址
        $loginFrame = config('define.site.login_frame');
        // 登录地址
        $loginUrl = config('rbac.user_auth_gateway');
        if (Request::ajax()) {
            $response = ajaxReturnAdvError("登录超时，请先登陆", 400, "", "", false, "", url($loginFrame));
            abort(400, $response);
        } else {
            if (strtolower($this->route['controller']) == 'index' && strtolower($this->route['action']) == 'index') {
                return redirect($loginUrl);
                //abort( 403,redirect($loginUrl));
            } else {
                //dd(urlencode(Request::url()));
                // 判断是弹出登录框还是直接跳转到登录页
                $ret = '<script>' .
                    'if(window.parent.frames.length == 0) ' .
                    'window.location = "' . url($loginUrl) . '?callback=' . urlencode(Request::url()) . '";' .
                    ' else ' .
                    'parent.login("' . url($loginFrame) . '");' .
                    '</script>';
                return response($ret);
            }
        }
    }

    /**
     * 权限校验
     */
    protected function auth()
    {
        // 用户权限检查
        if (config('rbac.user_auth_on') && !in_array($this->route['module'], explode(',', config('rbac.not_auth_module')))) {
            if (!Rbac::AccessCheck()) {
                abort(403, "没有权限");
            }
        }
    }
}
