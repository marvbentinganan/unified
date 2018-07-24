<div class="ui {{ $modifier }} selection dropdown">
    <input type="hidden" name="{{ $name }}">
    <i class="dropdown icon"></i>
    <div class="default text">{{ $default }}</div>
    <div class="menu">
        <div class="item" data-value="{{ $value }}">{{ $description }}</div>
    </div>
</div>
