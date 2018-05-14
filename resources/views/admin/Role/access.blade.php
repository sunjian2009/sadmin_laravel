@include('admin.header')
<div class="page-container">
        <div class="pt-5 pr-5 pos-f" style="right: 20px;top: 20px;">
            <button type="button" class="btn btn-primary radius save">&nbsp;&nbsp;保存&nbsp;&nbsp;</button>
            <button type="button" class="ml-20 btn btn-default radius" onclick="layer_close()">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
        </div>
    <div id="tree"></div>
</div>
<link rel="stylesheet" href="{{asset('admins/js/wdTree/css/tree.css')}}">
<script type="text/javascript" src="{{asset('admins/js/wdTree/jquery.tree.js')}}"></script>
<script>
    $(function () {
        $("#tree").treeview({
            showcheck: true,
            cbiconpath:"{{ asset('admins/js/wdTree/css/images/icons/') }}"+'/',
            data:{!! $tree !!},
            theme:'bbit-tree-lines',
        });

        $(".save").click(function () {
            var node = $("#tree").getCheckedNodes();
            ajax_req("{{url('admin/role/access')}}",{id:'{{request('id')}}','node_id':node},undefined,undefined,true);
        });
    })
</script>
@include('admin.footer')