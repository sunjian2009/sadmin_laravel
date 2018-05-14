@include('admin.header')
@inject('rbac', '\App\Services\Rbac')
<div class="pos-f tp-page-aside">
    <div class="panel panel-primary tp-panel tp-panel-module">
        <div class="panel-header">模块</div>
        <div class="panel-body tp-box-list">
            <ul id="module-list">
                @foreach($modules as $module)
                    <li data-module-id="{{$module['id']}}">
                        <a href="javascript:;" class="list-select">{{$module['title']}}（{{$module['name']}}）</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="panel panel-primary tp-panel tp-panel-group">
        <div class="panel-header">分组</div>
        <div class="panel-body tp-box-list">
            <ul id="group-list">
                <li data-group-id="0"><a href="javascript:;" class="list-select"><i class="Hui-iconfont"></i> 未分组</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="tp-page-main">
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray">
        <span class="l">
            @if($rbac::AccessCheck('add'))
                <a class="btn btn-primary radius J_add" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加</a>
            @endif
            @if($rbac::AccessCheck('forbid'))
                <a href="javascript:;" onclick="treeOpAll('{{url('admin/node/forbid')}}', '禁用')"
                   class="btn btn-warning radius ml-5"><i class="Hui-iconfont">&#xe631;</i> 禁用</a>
            @endif
            @if($rbac::AccessCheck('resume'))
                <a href="javascript:;" onclick="treeOpAll('{{url('admin/node/resume')}}', '恢复')"
                   class="btn btn-success radius ml-5"><i class="Hui-iconfont">&#xe615;</i> 恢复</a>
            @endif
            @if($rbac::AccessCheck('delete'))
                <a href="javascript:;" onclick="treeOpAll('{{url('admin/node/delete')}}', '删除')"
                   class="btn btn-danger radius ml-5"><i class="Hui-iconfont">&#xe6e2;</i> 删除</a>
            @endif
            @if($rbac::AccessCheck('recyclebin')) @endif
            {{--@if($rbac::AccessCheck('load'))--}}
                {{--<a href="javascript:;" class="btn btn-primary radius J_load"><i--}}
                            {{--class="Hui-iconfont">&#xe645;</i> 批量导入</a>--}}
            {{--@endif--}}
        </span>
        </div>
        <div class="zTreeDemoBackground left">
            <ul id="tree" class="ztree"></ul>
        </div>
    </div>
</div>

<div id="rMenu">
    <ul>
        <li class="J_add" onclick="hideRMenu();">添加节点</li>
        <li onclick="hideRMenu();onEditName('tree', zTree.getSelectedNodes()[0]);">编辑节点</li>
        <li onclick="hideRMenu();onRemove('tree', zTree.getSelectedNodes()[0]);">删除节点</li>
        <li onclick="checkTreeNode(true);">选中节点</li>
        <li onclick="checkTreeNode(false);">取消选择</li>
    </ul>
</div>
<link rel="stylesheet" href="{{ asset('admins/js/zTree/css/zTreeStyle/zTreeStyle.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('admins/js/contextmenu/jquery.contextmenu.css') }}" type="text/css">
<style type="text/css">
    div#rMenu {
        position: absolute;
        visibility: hidden;
        top: 0;
        background-color: #555;
        text-align: left;
        padding: 2px;
    }

    div#rMenu ul li {
        margin: 1px 0;
        padding: 0 5px;
        cursor: pointer;
        list-style: none outside none;
        background-color: #DFDFDF;
    }
</style>


<script type="text/javascript" src="{{ asset('admins/js/zTree/js/jquery.ztree.all.js') }}"></script>
<script type="text/javascript" src="{{ asset('admins/js/contextmenu/jquery.contextmenu.js') }}"></script>
<script type="text/javascript">
    // 当前链接
    var APP_CURRENT = APP_CONTROLLER;
</script>
<script type="text/javascript" src="{{ asset('admins/js/admin_node.js') }}"></script>
@include('admin.footer')