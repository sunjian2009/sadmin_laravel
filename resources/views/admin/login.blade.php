<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport"
          content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="Bookmark" href="{{public_path()}}/favicon.ico">
    <link rel="Shortcut Icon" href="{{public_path()}}/favicon.ico"/>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/html5shiv.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/respond.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('admins/hui/lib/PIE_IE678.js') }}"></script>
    <![endif]-->

    <link href="{{ asset('admins/hui/static/h-ui/css/H-ui.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('admins/hui/static/h-ui.admin/css/H-ui.login.css') }}" rel="stylesheet" type="text/css"/>

    {{ asset('admins/hui/static/h-ui/js/H-ui.js') }}
    <!--[if IE 6]>
    <script type="text/javascript" src="{{ asset('admin/hui/lib/app.css') }}/DD_belatedPNG_0.0.8a-min.js"></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>{{ config('app.name', 'sadmin') }}</title>
    <meta name="keywords" content="{{config('define.site.keywords')}}">
    <meta name="description" content="{{config('define.site.description')}}">
    <style>
        .header {
            background: #426374;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>{{ config('app.name', 'sadmin') }} {{config('define.site.version')}} 后台管理系统</h1>

</div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
        <form class="form form-horizontal" action="{{url('admin/checkLogin')}}" method="post" id="form">
            <div class="row cl">
                <label class="form-label col-xs-3 col-ms-3" style="line-height: 36px;font-size: 20px;">帐号</label>
                <div class="formControls col-xs-6 col-ms-6">
                    <input name="account" type="text" placeholder="帐号" class="input-text size-L" datatype="*"
                           nullmsg="请填写帐号">
                </div>
                <div class="col-xs-3 col-ms-3"></div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3 col-ms-3" style="line-height: 40px;font-size: 20px;">密码</label>
                <div class="formControls col-xs-6 col-ms-6">
                    <input name="password" type="password" placeholder="密码" class="input-text size-L" datatype="*"
                           nullmsg="请填写密码">
                </div>
                <div class="col-xs-3 col-ms-3"></div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-6 col-ms-6 col-xs-offset-3 col-ms-offset-3">
                    <input name="captcha" class="input-text size-L" type="text" placeholder="验证码"
                           style="width:100px;min-width: auto" datatype="*" nullmsg="请填写验证码">
                    <img id="captcha" src="{{url('admin/captcha')}}" alt="验证码" title="点击刷新验证码"
                         style="cursor:pointer;width: 150px;height: 40px">
                </div>
                <div class="col-xs-3 col-ms-3"></div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-6 col-xs-offset-3">
                    <label for="online">
                        <input type="checkbox" name="online" id="online" value="1">
                        使我保持登录状态
                    </label>
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-6 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L mr-20"
                           value="&nbsp;登&nbsp;&nbsp;&nbsp;&nbsp;录&nbsp;">
                    <input name="" type="reset" class="btn btn-default radius size-L"
                           value="&nbsp;重&nbsp;&nbsp;&nbsp;&nbsp;置&nbsp;">
                </div>
            </div>
            {{ csrf_field() }}
        </form>
    </div>
</div>
<div class="footer">Copyright Spring by {{ config('app.name', 'sadmin') }} {{config('define.site.version')}}</div>
<script type="text/javascript" src="{{ asset('admins/hui/lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/hui/lib/layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/hui/lib/Validform/5.3.2/Validform.min.js') }}"></script>
<script>
    $(function () {
        $("#captcha").click(function () {
            $(this).attr("src", "{{url('admin/captcha')}}?t=" + new Date().getTime())
        });

        $("#form").Validform({
            tiptype: 2,
            ajaxPost: true,
            showAllError: true,
            callback: function (ret) {
                if (ret.code) {
                    if (ret.msg == '验证码错误!') {
                        $("#captcha").click();
                        $("[name='captcha']").val('');
                        layer.msg(ret.msg);
                    } else {
                        layer.alert(ret.msg);
                    }
                } else if(ret.code==0) {
                    layer.msg("登录成功！");
                    location.href = '{{$info['callback'] or url('admin')}}';
                }
            }
        });
    })
</script>
</body>
</html>