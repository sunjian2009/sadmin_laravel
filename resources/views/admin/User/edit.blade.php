@include('admin.header')
<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="{{url('admin/user/edit')}}">
        <input type="hidden" name="id" value="{{$vo['id']}}">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>帐号：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="{{$vo['account']}}" readonly >
            </div>
            <div class="col-xs-3 col-sm-3"><span class="label label-warning radius">不可更改</span></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>姓名：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="{{$vo['realname']}}" placeholder="" name="realname" datatype="*" nullmsg="请填写姓名">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">邮箱：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="{{$vo['email']}}" placeholder="" name="email" datatype="e" ignore="ignore" errormsg="邮箱格式错误">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">手机：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" value="{{$vo['mobile']}}" placeholder="" name="mobile" datatype="m" ignore="ignore" errormsg="手机格式错误">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>状态：</label>
            <div class="formControls col-xs-6 col-sm-6 skin-minimal">
                <div class="radio-box">
                    <input type="radio" name="status" id="status-1" value="1" datatype="*" nullmsg="请选择状态">
                    <label for="status-1">启用</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="status" id="status-0" value="0">
                    <label for="status-0">禁用</label>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">备注：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <textarea class="textarea" placeholder="" name="remark" onKeyUp="textarealength(this,100)">{{$vo['remark']}}</textarea>
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
        $("[name='status'][value='{{$vo['status'] or '1'}}']").attr("checked",true);

        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $("#form").Validform({
            tiptype:2,
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                ajax_progress(ret);
            }
        });
    })
</script>
@include('admin.footer')