@inject('request', '\Illuminate\Support\Facades\Request')
<form class="mb-20" method="get" action="{{url('admin/user')}}">
    <div class="text-left ">名称:
        <span class="select-box inline">
		<select class="select" name="name[ex]">
			<option value="">无条件</option>
			<option value="=" @if ($request::input('name.ex') == '=')selected @endif>等于</option>
			<option value="like" @if ($request::input('name.ex') == 'like')selected @endif>包含</option>
			<option value=">" @if ($request::input('name.ex') == '>')selected @endif>大于</option>
			<option value="<" @if ($request::input('name.ex') == '<')selected @endif>小于</option>
			<option value="<>" @if ($request::input('name.ex') == '<>')selected @endif>不等于</option>
		</select>
		</span>
        <input type="text" class="input-text" style="width:250px" placeholder="名称" name="name[value]" value="{{$request::input('name.value')}}">
        {{--<input type="text" class="input-text" style="width:250px" placeholder="分组名称" name="name[value]" value="{{request('name.value')}}">--}}
        <button type="submit" class="btn btn-success"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
</form>