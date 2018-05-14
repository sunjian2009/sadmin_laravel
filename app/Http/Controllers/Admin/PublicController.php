<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use App\Services\Common;
use App\Services\Rbac;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\DB;
use Zhuzhichao\IpLocationZh\Ip;
use Jenssegers\Agent\Agent;
use App\Http\Requests\UserRequest;
class PublicController extends CommonController
{




    public function login()
    {
        $callback = request('callback');
        return view('admin.login', ['info' => ['callback' => $callback]]);
    }

    public function loginFrame(){
        return view('admin.login_frame');
    }
    /**
     * 用户登出
     */
    public function logout()
    {
        if (Session::get(config('rbac.user_auth_key'))) {
            Session::flush();
            return ajaxReturnAdv('登出成功！',config('rbac.user_auth_gateway'));
        } else {
            return ajaxReturnAdvError('登出成功！',config('rbac.user_auth_gateway'));
        }
    }
    //生成验证码
    public function captcha()
    {
        //生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder;
        $builder->build($width = 250, $height = 70, $font = null);
        $phrase = $builder->getPhrase();
        Session::put('login_captcha', $phrase);
        //生成图片
        header("Cache-Control: no-cache, must-revalidate");
        header('Content-Type: image/jpeg');
        $builder->output();
    }

    public function welcome()
    {
//        dd(Session::all());
        // 查询 ip 地址和登录地点
        //if (Session::get('last_login_time')) {
            $last_login_ip = Session::get('last_login_ip');
            $last_login_loc = Ip::find($last_login_ip);
        //}
        $current_login_ip = $this->request->getClientIp();
        $current_login_loc = Ip::find($current_login_ip);
        // 查询个人信息
        $info = DB::table('admin_user')->where("id", $this->uid)->first();
        $data = [
            'info' => $info,
            'last_login_ip' => $last_login_ip,
            'last_login_loc' => $last_login_loc[0] . $last_login_loc[1] . $last_login_loc[2],
            'current_login_ip' => $current_login_ip,
            'current_login_loc' => $current_login_loc[0] . $current_login_loc[1] . $current_login_loc[2]
        ];
        return view('admin.welcome', $data);
    }

    public function upload()
    {

    }

    /**
     * 登录检测
     */
    public function checkLogin()
    {
        if ($this->request->isMethod('post')) {
            $data = $this->request->input();
            if (Session::get('login_captcha') != request('captcha')) {
                return ajaxReturnAdvError('验证码错误！');
            }
            $userRequest=new UserRequest();
            $validator = validator($data, $userRequest->customRules['login'], $userRequest->messages);
            if ($validator->fails()) {
//                var_dump($validator->errors()->toArray());
//                die;
                return ajaxReturnAdvError($validator->errors()->first());
            }
            $authInfo = Rbac::authenticate($data['account']);
            // 使用用户名、密码和状态的方式进行认证
            if (null === $authInfo) {
                return ajaxReturnAdvError('帐号不存在或已禁用！');
            } else {
                if ($authInfo->password != Common::passwordHash($data['password'])) {
                    return ajaxReturnAdvError('密码错误！');
                }
                // 生成session信息
                Session::put(config('rbac.user_auth_key'), $authInfo->id);
                Session::put('user_name', $authInfo->account);
                Session::put('real_name', $authInfo->realname);
                Session::put('last_login_ip', $authInfo->last_login_ip);
                Session::put('last_login_time', $authInfo->last_login_time);
                // 超级管理员标记
                if ($authInfo->id == 1) {
                    Session::put(config('rbac.admin_auth_key'), true);
                }
                // 保存登录信息
                $update['last_login_time'] = \Carbon\Carbon::now();
                //$update['login_count'] = 'login_count+1';
                $update['last_login_ip'] = $this->request->getClientIp();
                Db::table("admin_user")->where('id', $authInfo->id)->update($update);
                // 记录登录日志
                $log['uid'] = $authInfo->id;
                $log['login_ip'] = $this->request->getClientIp();
                $city=Ip::find($log['login_ip']);
                $log['login_location'] = $city[0].$city[1].$city[2];
                $agent = new Agent();
                $log['login_browser'] = $agent->browser();
                $log['login_os'] = $agent->platform();
                Db::table("admin_login_log")->insert($log);
                // 缓存访问权限
                Rbac::saveAccessList();
                return ajaxReturnAdv('登录成功！', '');
            }
        } else {
            abort(403, "非法请求");
        }
    }
}

