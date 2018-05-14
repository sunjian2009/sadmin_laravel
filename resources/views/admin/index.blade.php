@include('admin.header')
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl">
            <a class="logo navbar-logo f-l mr-10 hidden-xs" href="{{url('/admin')}}">{{ config('app.name', 'sadmin') }}</a>
            <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="{{url('/admin')}}"></a>
            <!-- <span class="logo navbar-slogan f-l mr-10 hidden-xs"{{config('define.site.version')}}</span> -->
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <!-- {include file='template/nav_left' /} -->
            <nav class="nav navbar-nav">

                <ul class="cl">
                    <li class="dropDown dropDown_hover open"><a href="{{url('/admin')}}" class="dropDown_A">
                            <!--<i class="Hui-iconfont">&#xe600;</i>-->
                            首页
                            <!--<i class="Hui-iconfont">&#xe6d5;-->
                            </i>
                        </a>

                    </li>
                    <li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 预留菜单 <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
                            <li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>
                            <li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
                            <li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
                        </ul>
                    </li>
                    <li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 预留菜单 <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onclick="article_add('添加资讯','article-add.html')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
                            <li><a href="javascript:;" onclick="picture_add('添加资讯','picture-add.html')"><i class="Hui-iconfont">&#xe613;</i> 图片</a></li>
                            <li><a href="javascript:;" onclick="product_add('添加资讯','product-add.html')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
                            <li><a href="javascript:;" onclick="member_add('添加用户','member-add.html','','510')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>{{session('user_name')}}</li>
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">{{session('real_name')}} <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onclick="layer_open('个人信息', '{{url('admin/profile')}}')">个人信息</a></li>
                            <li><a href="javascript:;" onclick="layer_open('修改密码', '{{url('admin/adminPassword')}}')">修改密码</a></li>
                            <li><a href="javascript:;" onclick="logout()">退出</a></li>
                        </ul>
                    </li>
                    <li id="Hui-msg"> <a href="javascript:;" onclick="layer.msg('消息')" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="绿色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <div class="menu_dropdown bk_2">
        <!--左侧菜单-->
        @include('admin.nav_menu')
    </div>
</aside>
<div class="dislpayArrow hidden-xs">
    <a class="pngfix" href="javascript:javascript:void(0)" onClick="displaynavbar(this)"></a>
</div>
<section class="Hui-article-box">
    <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
        <div class="Hui-tabNav-wp">
            <ul id="min_title_list" class="acrossTab cl">
                <li class="active"><span title="我的桌面" data-href="{{url('admin/welcome')}}">我的桌面</span><em></em></li>
            </ul>
        </div>
        <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
    </div>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <iframe scrolling="yes" frameborder="0" src="{{url('admin/welcome')}}"></iframe>
        </div>
    </div>
</section>
<script type="text/javascript" src="{{ asset('admins/hui/lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/hui/lib//layer/2.4/layer.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/hui/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/hui/static/h-ui.admin/js/H-ui.admin.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/js/app.js') }}"></script>

<script>
    function logout() {
        layer.confirm('您确定要退出登录？', {
            title: '登出提醒'
        }, function(index) {
            location.href = '{{url("admin/logout")}}'
        })
    }
</script>

@include('admin.footer')