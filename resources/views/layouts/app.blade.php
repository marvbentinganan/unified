<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" id="favicon">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    @stack('header_scripts')

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">

<body>
    <header>
    @include('partials.sidebar')
    @include('partials.main_navigation')
    </header>
    <main class="dimmed pusher">
        <div id="app" style="padding-top: 50px;">
            <div class="ui stackable two column padded grid">
                <div class="three wide computer only three wide tablet only column">
                    @include('partials.left_navigation')
                </div>
                <div class="sixteen wide mobile only thirteen wide computer only thirteen wide tablet only column">
                    <div class="ui small breadcrumb">
                        @yield('breadcrumb')
                    </div>
                    <div class="ui section divider"></div>
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/semantic-ui/semantic.min.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    
    <footer>
        <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
        <script>
            function confirm(){
                    swal({ title: 'Are you sure?',
                    text: "You will be logged out of the system",
                    type: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes' })
                    .then((result) => {
                        if (result.value){
                            $('#logout').submit();
                        }
                    })
                }
                function showSidebar(){
                    $('.sidebar').sidebar('setting', 'transition', 'push').sidebar('toggle');
                }
        
                $('.dropdown').dropdown({
                    clearable : true
                });
        </script>
        @yield('footer')
        @stack('footer_scripts')
        {{--
        <script src="{{ asset('js/app.js') }}"></script> --}}
    </footer>
</body>

</html>
