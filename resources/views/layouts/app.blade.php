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
    {{--
    <script src="{{ asset('js/app.js') }}" defer></script> --}}
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
            <div class="ui stackable very padded grid">
                <div class="sixteen wide column">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/semantic-ui/semantic.min.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>
    
    <footer>
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
        
                $('.dropdown').dropdown();
        </script>
        @yield('footer')
        @stack('footer_scripts')
    </footer>
</body>

</html>
