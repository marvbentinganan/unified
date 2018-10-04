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
    <link href="{{ asset('plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semantic-ui/semantic.min.css') }}" rel="stylesheet">
    <style>
        body{
            background: rgb(2,25,94); background: linear-gradient(120deg, rgba(2,25,94,1) 35%, rgba(9,29,121,0.8029411593739058) 57%,
            rgba(5,71,148,1) 81%);
        }
    </style>
</head>

<body>
    <div class="ui hidden divider"></div>
    <div class="ui grid container">   
        <div class="centered eight wide middle aligned column">
            <div class="ui raised fluid card">
                <div class="image">
                    <img src="{{ asset('images/digihub-logo.jpg') }}" alt="">
                </div>
                <div class="content">
                    <div class="header">Guidelines</div>
                    <div class="description">
                        <div class="ui relaxed divided list">
                            <div class="item">
                                <i class="large ion-information-circled icon"></i>
                                <div class="content">
                                    <div class="header">Time Limit</div>
                                    <div class="description">The use of this machine is limited to fourty-five (45) minutes only per user. After the alloted time, the computer
                                        will automatically restart so please save your work.</div>
                                </div>
                            </div>
                            <div class="item">
                                <i class="large ion-information-circled icon"></i>
                                <div class="content">
                                    <div class="header">Security</div>
                                    <div class="description">In order to protect our computer units from viruses and malwares, please avoid browsing unsecured sites.</div>
                                </div>
                            </div>
                            <div class="item">
                                <i class="large ion-information-circled icon"></i>
                                <div class="content">
                                    <div class="header">Downloads</div>
                                    <div class="description">Downloading of movies, music, and other pirated or unlicensed materials is discouraged.</div>
                                </div>
                            </div>
                            <div class="item">
                                <i class="large ion-information-circled icon"></i>
                                <div class="content">
                                    <div class="header">File Transfer</div>
                                    <div class="description">A USB port is provided to save your files, please handle with care.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>