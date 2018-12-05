<div id="offcanvas-nav" uk-offcanvas="flip: false; mode: reveal; overlay: true">
    <div class="uk-offcanvas-bar">
        <ul class="uk-nav uk-nav-default">
            @auth
            {{-- <div class="uk-card uk-card-secondary uk-card-small">
                <div class="uk-card-media-top">
                    <img src="{{ asset('images/avatar.jpg') }}">
                </div>
                <div class="uk-card-body">
                    <h3 class="uk-card-title">{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</h3>
                </div>
            </div> --}}
            
            <li><a href=""><span class="uk-margin-small-right" uk-icon="icon: folder"></span> Shared Files</a></li>
            <li><a href=""><span class="uk-margin-small-right" uk-icon="icon: list"></span> View All Grades</a></li>
            <li><a href=""><span class="uk-margin-small-right" uk-icon="icon: cog"></span> Account Settings</a></li>
            <li class="uk-nav-divider"></li>
            <li>
                <a href="#confirmation" uk-toggle><span class="uk-margin-small-right" uk-icon="icon: sign-out"></span> Logout</a>
            </li>
            @endauth
        </ul>
    </div>
</div>
<div id="confirmation" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Confirmation</h2>
        </div>
        <div class="uk-modal-body">
            <p>Are you sure you want to Log out?</p>
            <form action="{{ route('logout') }}" method="POST" style="display: hidden;">
                @csrf
                <p class="uk-text-right">
                    <button class="uk-button uk-button-default uk-modal-close" type="button">No</button>
                    <button class="uk-button uk-button-primary" type="submit">Yes</button>
                </p>
            </form>
        </div>
    </div>
</div>