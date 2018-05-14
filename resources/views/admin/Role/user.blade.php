@include('admin.header')
<div class="page-container">
    <form action="{{url('admin/role/user')}}" method="post" id="form" style="padding-top: 50px">
        <input type="hidden" name="id" VALUE="{{request('id')}}" />
        <div class="cl pd-5 bg-1 bk-gray pos-f" style="left: 20px;right: 20px;top: 20px;">
            <span class="l">
                <button type="button" class="btn btn-primary radius" onclick="$('#checkAll').click()">&nbsp;&nbsp;全选&nbsp;&nbsp;</button>
            </span>
            <span class="r pt-5 pr-5">
                <button type="submit" class="btn btn-primary radius">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
                <button type="button" class="ml-20 btn btn-default radius" onclick="layer_close()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
            </span>
        </div>
        <table class="table table-border table-bordered table-hover table-bg mt-20">
            <thead>
            <tr class="text-c">
                <th width="80">
                    <div class="check-box">
                        <input type="checkbox" id="checkAll">
                    </div>
                </th>
                <th width="150">帐号</th>
                <th width="150">姓名</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($list as $vo)
            <tr class="text-c">
                <td>
                    <div class="check-box">
                        <input type="checkbox" name="user_id[]" value="{{$vo['id']}}"  @if ($vo['checked'] == 1)checked @endif>
                    </div>
                </td>
                <td>{{$vo['account']}}</td>
                <td>{{$vo['realname']}}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </form>
</div>
@include('admin.footer')
<script type="text/javascript" src="{{ asset('admins/js/Validform/5.3.2/Validform.min.js') }}"></script>
<script>
    $(function () {
        var checks = '{$checks}'.split(",");
        if (checks.length > 0){
            for (var i in checks){
                $("[name='user_id[]'][value='"+checks[i]+"']").attr("checked",true);
            }
        }

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