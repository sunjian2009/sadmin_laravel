@inject('request', '\Illuminate\Support\Facades\Request')
<form class="mb-20" method="get" action="{{url('admin/loginLog')}}">
	<div class="text-left ">用户id:
<span class="select-box inline">
		<select class="select" name="uid[ex]">
			<option value="">无条件</option>
			<option value="=" @if ($request::input('uid.ex') == '=')selected @endif>等于</option>
			<option value="like" @if ($request::input('uid.ex') == 'like')selected @endif>包含</option>
			<option value=">" @if ($request::input('uid.ex') == '>')selected @endif>大于</option>
			<option value="<" @if ($request::input('uid.ex') == '<')selected @endif>小于</option>
			<option value="<>" @if ($request::input('uid.ex') == '<>')selected @endif>不等于</option>
		</select>
		</span>
    <input type="text" class="input-text" style="width:250px" placeholder="用户id" name="uid[value]" value="{{$request::input('uid.value')}}">
    <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
	</div>
</form>


