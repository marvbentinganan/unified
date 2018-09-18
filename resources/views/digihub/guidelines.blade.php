<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ 'Guidelines | '.config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
    <link href="{{ asset('css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                <img src="{{ asset('images/digihub-logo.jpg') }}" alt="">
            </div>
            {{-- <div class="links">
                <a href="#">Faculty Evaluation</a>
                <a href="#">RCI WiFi</a>
                <a href="#">DigiHub</a>
                <a href="#">Events Attendance</a>
            </div> --}}
        </div>
    </div>
    <div class="ui sixteen wide coumn">
        <div class="ui segment">
            <h1 class="ui huge centered header">Usage Guidelines</h1>
            <div class="ui relaxed divided list">
                <div class="item">
                    The use of this machine is limited to forty-five (45) minutes only per user. After the alloted time, the computer will automatically
                    restart so please save your work.
                </div>
                <div class="item">
                    In order to protect our computer units from viruses and malwares, please avoid browsing unsecured sites.
                </div>
                <div class="item">
                    Downloading of movies, music, and other pirated/unlicensed materials is discouraged.
                </div>
                <div class="item">
                    A USB port is provided to save your files, please handle with care.
                </div>
            </div>
        </div>
    </div>
</body>

</html>