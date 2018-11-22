<div class="ui large left vertical accordion sidebar menu">
    @foreach($menus as $menu) @if($menu->has_children == true)
    <div class="item">
        <div class="title">
            {{ $menu->name }}
            <i class="{{ $menu->icon }} icon"></i>
        </div>
        <div class="content">
            <div class="menu">
                @foreach($menu->children as $child)
                <a href="{{ route($child->link) }}" class="item">
                    {{ $child->name }}
                    <i class="{{ $child->icon }} icon"></i>
                </a> @endforeach
            </div>
        </div>
    </div>
    @else
    <a href="{{ route($menu->link) }}" class="item">
        {{ $menu->name }}
        <i class="{{ $menu->icon }} icon"></i>
    </a> @endif @endforeach
    <a class="item" onclick="confirm()">
        Sign Out
        <i class="ion-log-out icon"></i>
    </a>
</div>

@push('footer_scripts')
<script>
    $('.accordion').accordion();
</script>
@endpush
