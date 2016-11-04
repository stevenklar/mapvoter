<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Map Voter</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
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

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            <!-- Maps style -->
            .maps ul {
            }
            .maps li {
                float: left;
                margin: 10px;
                list-style-type: none;
            }
            .maps li span {
                position: absolute;
                color: white;
                margin: 1rem;
                font-size: 15px;
                font-weight: 400;
                background-color: black;
                padding: 5px 20px 5px 20px;
            }
            .maps img {
                max-width: 200px;
            }
            img.dismissed {
                position: fixed;
                left: 50px;
                height: 112px;
                background-color: grey;
                padding: 0px 43px 0px 44px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            <div style="margin-top: 30px; font-size: 30px">
                <a style="text-decoration: none;color: black;" href="https://desbl.de/index.php?public&site=showmatch&mid=24468" target="_blank">{{ $teams }}</a>
            </div>

            <div style="position: fixed; top: 10px;">
                {{ $date }}
            </div>

            <div class="top-right links">
                <div id="status" style="color: red;">Offline</div>
            </div>
        </div>

        <div class="flex-center position-ref">
            <div id="message" style="color: red;">
                Status: Es können noch keine Maps gevotet werden.
            </div>
        </div>

        <div class="flex-center position-ref full-height">

            <div class="content">
                <ul class="maps">
                    @foreach($activeMaps as $activeMap)
                        {!! $activeMap['link'] !!}
                    @endforeach
                </ul>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        @include('js/socket')
    </body>
</html>
