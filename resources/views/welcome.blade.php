<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Movie API</title>

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

            .top-right.links {
                text-align: right;
            }
            .top-right.links a {
                display: inline;
            }

            .links.routes {
                padding: 25px;
            }
            .links {
                width: 50%;
                margin: auto;
                display: block;
            }
            .links.routes a {
                padding: 25px;
                border: 1px solid #ccc;
                border-radius: 10px;
                margin: 25px;
                transition: 500ms ease background-color;
            }
            .links.routes a:hover {
                background-color: #eee;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                text-align: left;
                display: block;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Movie API Routes
                </div>
                <div class="links routes">
                    <a href="./home">Get API Key</a>
                    @if (Auth::check())
                        <a href="{{ '/graphql?query=query%20%7B%0A%20%20__schema%20%7B%0A%20%20%20%20types%20%7B%20name%20%7D%0A%20%20%7D%0A%7D&api_token=' .  Auth::user()->api_token }}">Graph Web API</a>
                    @else
                        <a href="./graphql">Graph Web API</a>
                    @endif
                    <a href="./graphiql">Interactive Web API with documentation</a>
                </div>
            </div>
        </div>
    </body>
</html>
