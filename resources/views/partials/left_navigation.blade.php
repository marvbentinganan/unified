<div class="ui fluid small borderless vertical menu"> 
    @foreach($menus as $menu) 
    @if($menu->has_children == true)
    <div href="" class="ui dropdown item">
        {{ $menu->name }}
        <i class="dropdown icon"></i>
        <div class="menu">
            @foreach($menu->children as $child)
            <a href="{{ route($child->link) }}" class="item"><i class="{{ $child->icon }} icon"></i> {{ $child->name }}</a>
            @endforeach
        </div>
    </div>
    @else
    <a href="{{ route($menu->link) }}" class="item"><i class="{{ $menu->icon }} icon"></i>{{ $menu->name }}</a> 
    @endif 
    @endforeach
</div>