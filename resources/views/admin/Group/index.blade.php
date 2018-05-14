@include('admin.header')
@include('admin.refresh_bar')
@inject('request', '\Illuminate\Support\Facades\Request')
<div class="page-container">
    @include('admin.group.form')
    <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
            @include('admin.tag_menu',['menu'=>['add','saveOrder']])
        </span>
        <span class="r pt-5 pr-5">
            共有数据 ：<strong>{{$count}}</strong> 条
        </span>
    </div>
    <table class="table table-border table-bordered table-hover table-bg mt-20">
        <thead>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
            <th width="40">{!!sortBy('Id','id')!!}</th>
            <th width="200">分组名称</th>
            <th width="60">小图标</th>
            <th width="60">{!!sortBy('排序','sort')!!}</th>
            <th width="200">备注</th>
            <th width="60">{!!sortBy('状态','status')!!}</th>
            <th width="70">操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($list as $vo)
        <tr class="text-c">
            <td><input type="checkbox" name="id[]" value="{{$vo['id']}}"></td>
            <td>{{$vo['id']}}</td>
            <td>{!!highLight($vo['name'],$request::input('name.value'))!!}</td>
            <td><i class="Hui-iconfont">{{$vo['icon'] or '&#xe616;'}}</i></td>
            <td style="padding: 0">
                <input type="number" name="sort[{{$vo['id']}}]" value="{{$vo['sort']}}" style="width: 60px;" class="input-text text-c order-input" data-id="{{$vo['id']}}">
            </td>
            <td>{{$vo['remark']}}</td>
            <td>{!!getStatus($vo['status'])!!}</td>
            <td class="f-14">
                {!!showStatus($vo['status'],$vo['id'])!!}
                @include('admin.tag_menu',['menu'=>['sedit','sdelete'],'param'=>['id'=>$vo['id']]])
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <div class="page-bootstrap">{{$page}}</div>
</div>
@include('admin.footer')
