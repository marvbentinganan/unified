<div class="ui fluid special card">
    <div class="blurring dimmable image">
        <div class="ui inverted dimmer">
            <div class="content">
                <div class="center">
                    <div class="ui inverted button"><i class="ion-compose icon"></i>Edit</div>
                </div>
            </div>
        </div>
        <img src="{{ asset('images/avatar.jpg') }}" alt="">
    </div>
    <div class="content">
        <div class="header">{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</div>
        <div class="meta">
            <span class="date"><i class="id badge icon"></i>{{ auth()->user()->username }}</span>
        </div>
    </div>
</div>
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

@push('footer_scripts')
    <script>
        $('.special.card .image').dimmer({ on: 'hover' });
    </script>
@endpush