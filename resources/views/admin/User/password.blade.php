@include('admin.header')
<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="{{url('admin/user/password')}}">
        <input type="hidden" name="id" value="{{request('id')}}">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>新密码：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="password" class="input-text" placeholder="请填写6-32位任意字符" name="password" datatype="/^[\w\W]{6,32}$/" nullmsg="请填写密码" errormsg="请填写6-32位任意字符">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>重复密码：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="password" class="input-text" placeholder="请填写6-32位任意字符" name="repassword" datatype="/^[\w\W]{6,32}$/" nullmsg="请填写密码" errormsg="两次输入的密码不一致" recheck="password">
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
@include('admin.footer');
<script type="text/javascript" src="{{ asset('admins/js/Validform/5.3.2/Validform.min.js') }}"></script>
<script>
    $(function () {
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