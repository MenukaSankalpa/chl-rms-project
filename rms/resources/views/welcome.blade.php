<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RMS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
            background-image: url('{{url('image/1200.jpg')}}');
            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
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
            color: white;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .background-white {
            position: absolute;
            right: 0;
            top: 0;
            width: 100%;
            padding: 30px;
            background-color: white;
        }

        .opacity-fill {
            background: black;
            filter: alpha(opacity=60);
            /* IE */
            -moz-opacity: 0.6;
            /* Mozilla */
            opacity: 0.6;
            /* CSS3 */
            /*position: absolute;*/
            /*top: 352px;*/
            /*width: 1038px;*/
            /*height: 325px;*/
            /*padding-bottom: 10px;*/
            z-index: 1;
        }
        .logo{
            -webkit-animation-name: anim; /* Safari 4.0 - 8.0 */
            -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
            animation-name: anim;
            animation-duration: 4s;        }
        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes anim {
            from {
                -webkit-transform: rotateX(90deg); /* Safari prior 9.0 */
            }
            to {
                -webkit-transform: rotateX(0deg); /* Safari prior 9.0 */
            }
        }

        /* Standard syntax */
        @keyframes anim {
            from {                transform: rotateX(90deg); /* Standard syntax */
            }
            to {                transform: rotateX(0deg); /* Standard syntax */
            }
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="background-white">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>

    <div class="content">

        <div style="
        /*border: solid 3px dodgerblue;*/
         padding: 20px 0px;
         background-color: rgba(00,00,00,0.6);
         width:100vw;
         /*position: relative;*/
">
            <div class="logo" style="background-color: rgba(255,255,255,0.6); padding: 20px 0px ;">
                <img src="{{url('image/logo.png')}}">
            </div>
            <div class="title m-b-md" >
                Reefer Management System
            </div>
        </div>
    </div>
</div>
</body>
</html>
