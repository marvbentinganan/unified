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
    
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    @stack('header_scripts')
    
    <!-- Fonts -->
    
    <!-- Styles -->
    <link href="{{ asset('css/uikit/uikit.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>
<body style="display:flex; min-height:100vh; flex-direction:column;">
    <header>
        <div class="uk-grid">
            {{-- Cover Photo and Profile Picture --}}
            <div class="uk-width-1-1 uk-background-cover uk-height-medium uk-flex uk-flex-center uk-flex-middle" style="background-image: url({{ asset('images/header.jpg') }});">
                <div class="uk-card-small uk-text-center">
                    <div class="uk-card-media-top">
                        <img src="{{ asset('images/avatar.jpg') }}" alt="" width="150" height="150" class="uk-border-circle">
                    </div>
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-text-primary">{{ auth()->user()->firstname.' '.auth()->user()->lastname }}</h3>
                    </div>
                </div>
            </div>
            {{-- Navbar --}}
            <div class="uk-width-1-1">
                <div class="uk-navbar-container tm-navbar-container uk-sticky" uk-sticky="media: 960">
                    <div class="uk-container uk-container-expand uk-section-primary" uk-navbar>
                        <div class="uk-navbar">
                            <ul class="uk-navbar-nav">
                                <a class="uk-navbar-toggle" uk-navbar-toggle-icon uk-toggle="target: #offcanvas-nav"></a>
                                <li>
                                    <a href="{{ url('/student') }}"><span class="uk-icon uk-margin-small-right" uk-icon="icon: home"></span> Home</a>
                                </li>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.offcanvas')
    </header>
    <main id="app">
        {{-- <ul class="uk-breadcrumb">
            @yield('breadcrumb')
        </ul> --}}
        <div style="flex: 1;" class="uk-tile-muted">
            @yield('content')
        </div>
    </main>
    
    <footer>
        <script src="{{ asset('js/uikit/uikit.min.js') }}"></script>
        <script src="{{ asset('js/uikit/uikit-icons.min.js') }}"></script>
        <script src="{{ asset('js/all.js') }}"></script>
        <script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
        @yield('footer') @stack('footer_scripts') {{--
            <script src="{{ asset('js/app.js') }}"></script> --}}
        </footer>
    </body>
    
    </html>