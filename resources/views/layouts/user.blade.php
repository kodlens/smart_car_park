<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/img/tcnhs_logo.png">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="/js/app.js" defer></script>

    <!-- Fonts -->
    {{--    <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>

<body>
    
    <div id="app">
        
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img src="/img/logo.png" />
                    
                </b-navbar-item>
            </template>
    
            <template #start>
               
    
            </template>
    
            <template #end>
                
                <b-navbar-item href="/">
                    Home
                </b-navbar-item>
                <b-navbar-item href="/registration">
                    Register
                </b-navbar-item>
              
                <b-navbar-item tag="div">
                    @auth()
                        <div class="buttons">
                            <b-button label="LOGOUT" icon-left="logout" onclick="document.getElementById('logout').submit()">
                            </b-button>
                        </div>
                    @else
                        <div class="buttons">
                            <a class="button is-primary is-outlined" href="/login">
                                <strong>Login</strong>
                            </a>
                        </div>
                    @endauth
                </b-navbar-item>
                
            </template>
        </b-navbar>

        <form id="logout" action="/logout" method="post"> @csrf </form>

        <div>
            @yield('content')
        </div>
        
    </div>

    <script>
        
    </script>

</body>

</html>
