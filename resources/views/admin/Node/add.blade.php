@include('admin.header')
<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="{{url('admin/node/add')}}">
        <input type="hidden" name="pid" value="{{$vo['pid']}}">
        <input type="hidden" name="level" value="{{$vo['level'] or 1}}">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">分组：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <div class="select-box">
                    <select name="group_id" class="select">
                        <option value="0">未分组</option>
                        @foreach($group_list as $group)
                        <option value="{{$group['id']}}">{{$group['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>标题：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder=""
                       name="title" datatype="*" nullmsg="请填写标题">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>名称：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder="" name="name"
                       datatype="/[A-Za-z0-9_]+/" nullmsg="请填写名称" errormsg="名称只能是字母数字下划线">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">类型：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                    <input type="radio" name="type" id="type-1" value="1">
                    <label for="type-1">控制器</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="type" id="type-0" value="0">
                    <label for="type-0">方法</label>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="number" class="input-text" value="50" placeholder=""
                       name="sort" datatype="n" nullmsg="请填写排序" errormsg="只能填写数字">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                    <input type="radio" name="status" id="status-0" value="1" checked>
                    <label for="status-0">启用</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="status" id="status-1" value="0">
                    <label for="status-1">禁用</label>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>

        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-primary radius">&nbsp;&nbsp;提交&nbsp;&nbsp;</button>
                <button type="button" class="btn btn-default radius ml-20" onClick="layer_close();">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript" src="{{ asset('admins/js/Validform/5.3.2/Validform.min.js') }}"></script>
<script>
    $(function () {
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form").Validform({
            tiptype: 2,
            ajaxPost: true,
            showAllError: true,
            callback: function (ret) {
                ajax_progress(ret);
            }
        });
    })
</script>
@include('admin.footer')