@include('admin.header')
<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="{{url('admin/group/add')}}">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>分组名称：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="" placeholder="" name="name"
                       datatype="*" nullmsg="请填写分组名称">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">图标：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value=""
                       placeholder="不填先默认为列表图标" name="icon">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"></label>
            <div class="formControls col-xs-6 col-sm-6">
                小图标请到<a class="c-blue" href="http://h-ui.net/Hui-3.7-Hui-iconfont.shtml" target="_blank" rel="nofollow">http://h-ui.net/Hui-3.7-Hui-iconfont.shtml</a>复制tab标签为阿里巴巴Iconfont下的icon文字，如
                <span class="label label-success f-16">{{htmlspecialchars('&#xf0005;')}}</span>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>排序：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="number" class="input-text" value="50" placeholder=""
                       name="sort" datatype="*" nullmsg="请填写排序">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                    <input type="radio" name="status" id="radio-0" value="1" checked>
                    <label for="radio-0">启用</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="status" id="radio-1" value="0">
                    <label for="radio-1">禁用</label>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">备注：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <textarea class="textarea" placeholder="备注" name="remark" onKeyUp="textarealength(this, 100)"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
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
        $("[name='status'][value='{$vo.status ?? '1'}']").attr("checked", true);

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