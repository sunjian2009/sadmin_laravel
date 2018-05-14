@include('admin.header')
@include('admin.refresh_bar')
@inject('request', '\Illuminate\Support\Facades\Request')
<div class="page-container">
  @include('admin.group.form')
  <div class="cl pd-5 bg-1 bk-gray">
    <span class="l">
      @include('admin.tag_menu',['menu'=>['add','forbid','resume']])
        </span>
    <span class="r pt-5 pr-5">
            共有数据 ：<strong>{{$count}}</strong> 条
        </span>
  </div>
  <table class="table table-border table-bordered table-hover table-bg mt-20">
    <thead>
      <tr class="text-c">
        <th width="25"><input type="checkbox" value="" name=""></th>
        <th width="50">{!!sortBy('ID','id')!!}</th>
        <th width="100">姓名</th>
        <th width="100">帐号</th>
        <th width="150">邮箱</th>
        <th width="80">手机</th>
        <th width="80">{!!sortBy('添加时间','create_time')!!}</th>
        <th width="150">{!!sortBy('最后登录时间','last_login_time')!!}</th>
        <th width="60">{!!sortBy('登录次数','login_count')!!}</th>
        <th width="60">状态</th>
        <th width="80">备注</th>
        <th width="150">操作</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($list as $vo)
      <tr class="text-c">
        <td><input type="checkbox" name="id[]" value="{{$vo['id']}}"></td>
        <td>{{$vo['id']}}</td>
        <td>{!!highLight($vo['realname'],$request::input('realname.value'))!!}</td>
        <td>{!!highLight($vo['account'],$request::input('account.value'))!!}</td>
        <td>{!!highLight($vo['email'],$request::input('email.value'))!!}</td>
        <td>{!!highLight($vo['mobile'],$request::input('mobile.value'))!!}</td>
        <td>{{$vo['create_time']}}</td>
        <td>{{$vo['last_login_time']}}</td>
        <td>{{$vo['login_count']}}</td>
        <td>{!!getStatus($vo['status'])!!}</td>
        <td>{{$vo['remark']}}</td>

        <td class="f-14">
          {!!showStatus($vo['status'],$vo['id'])!!}
          @include('admin.tag_menu',['menu'=>['sedit','password'],'param'=>['id'=>$vo['id']]])
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  <div class="page-bootstrap">{{$page}}</div>
</div>
@include('admin.footer')
