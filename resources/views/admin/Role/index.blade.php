@include('admin.header')
@include('admin.refresh_bar')
@inject('request', '\Illuminate\Support\Facades\Request')
<div class="page-container">
    @include('admin.Role.form')
    <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
             @include('admin.tag_menu',['menu'=>['add']])
        </span>
        <span class="r pt-5 pr-5">
            共有数据 ：<strong>{{$count}}</strong> 条
        </span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
            <th width="50">{!!sortBy('Id','id')!!}</th>
            <th width="120">{!!sortBy('名称','name')!!}</th>
            <th width="80">状态</th>
            <th width="150">备注</th>
            <th width="150">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $vo)
        <tr class="text-c">
            <td><input type="checkbox" name="id[]" value="{{$vo['id']}}"></td>
            <td>{{$vo['id']}}</td>
            <td>{!!highLight($vo['name'],$request::input('name.value'))!!}</td>
            <td>{!!getStatus($vo['status'])!!}</td>
            <td>{{$vo['remark']}}</td>
            <td class="f-14">
                {!!showStatus($vo['status'],$vo['id'])!!}
                @include('admin.tag_menu',['menu'=>['sedit','sdelete','user','access'],'param'=>['id'=>$vo['id']]])
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="page-bootstrap">{{$page}}</div>
</div>
@include('admin.footer')
