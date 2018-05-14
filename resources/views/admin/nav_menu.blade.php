@foreach ($groups as $group)
<dl id="menu_{{$group['name']}}">
    <dt><i class="Hui-iconfont">{{$group['icon'] or '&#xe616;'}}</i> {{$group['name']}}<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
    <dd>
        <ul>
            @foreach ($menu[$group['id']] as $item)
                <li><a data-href="{{url('admin/'.$item['name'])}}" data-title="{{$item['title']}}" href="javascript:void(0)">{{$item['title']}}</a></li>
            @endforeach
        </ul>
    </dd>
</dl>
@endforeach

