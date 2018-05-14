@include('admin.header')
@include('admin.refresh_bar')
@inject('request', '\Illuminate\Support\Facades\Request')
<div class="page-container">
    @include('admin.loginLog.form')
    <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
        </span>
        <span class="r pt-5 pr-5">
            共有数据 ：<strong>{{$count}}</strong> 条
        </span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
            <th width="">{!!sortBy('用户ID','uid')!!}</th>
            <th width="">{!!sortBy('用户帐号','account')!!}</th>
            <th width="">用户姓名</th>
            <th width="">登录IP</th>
            <th width="">登录地点</th>
            <th width="">浏览器</th>
            <th width="">操作系统</th>
            <th width="">登录时间</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $vo)
        <tr class="text-c">
            <td><input type="checkbox" name="id[]" value="{{$vo['id']}}"></td>
            <td>{!!highLight($vo['uid'],$request::input('uid.value'))!!}</td>
            <td>{{$vo['user']['account']}}</td>
            <td>{{$vo['user']['realname']}}</td>
            <td>{{$vo['login_ip']}}</td>
            <td>{!!highLight($vo['login_location'],$request::input('login_location.value'))!!}</td>
            <td>{{$vo['login_browser']}}</td>
            <td>{{$vo['login_os']}}</td>
            <td>{{$vo['login_time']}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="page-bootstrap">{{$page}}</div>
</div>
@include('admin.footer')