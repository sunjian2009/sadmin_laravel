@include('admin.header')
<div class="page-container">
    <form class="form form-horizontal" id="form" method="post" action="{{url('admin/checkLogin')}}">
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>帐号：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="text" class="input-text" placeholder="帐号" name="account" datatype="*" nullmsg="请填写帐号">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3"><span class="c-red">*</span>密码：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input type="password" class="input-text" placeholder="密码" name="password" datatype="*" nullmsg="请填写密码">
            </div>
            <div class="col-xs-3 col-sm-3"></div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-3 col-sm-3">验证码：</label>
            <div class="formControls col-xs-6 col-sm-6">
                <input name="captcha" class="input-text" type="text" placeholder="验证码" style="width:100px;" datatype="*" nullmsg="请填写验证码">
                <img id="captcha" src="{{url('admin/captcha')}}" alt="验证码" title="点击刷新验证码" style="cursor:pointer;width: 150px;height: 40px">
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
        $("#captcha").click(function () {
            // $(this).attr("src","{:captcha_src()}?t="+new Date().getTime())
            $(this).attr("src", "{{url('admin/captcha')}}?t=" + new Date().getTime())
        });

        $("#form").Validform({
            tiptype:2,
            ajaxPost:true,
            showAllError:true,
            callback:function(ret){
                ajax_progress(ret);
                if (ret.status == 'n'){
                    if (ret.info == '验证码错误!'){
                        $("#captcha").click();
                    }
                }
            }
        });
    })
</script>