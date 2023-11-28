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
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    {{--    <link rel="dns-prefetch" href="//fonts.gstatic.com"> --}}
    {{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    
   
    <div id="app">
        
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img src="/img/car_park_logo.png" />
                </b-navbar-item>
            </template>
    
            <template #start>
            
    
            </template>
    
            <template #end>
                
                <b-navbar-item href="/user/dashboard">
                    Home
                </b-navbar-item>

                <b-navbar-dropdown label="Settings">

                    <b-navbar-item href="/#">
                        Item 1
                    </b-navbar-item>

                    <b-navbar-item href="/#">
                        Item 2
                    </b-navbar-item>
    
                </b-navbar-dropdown>

                <b-navbar-dropdown label="{{ strtoupper(Auth::user()->fname) }}">

                    <b-navbar-item href="/#">
                        My Profile
                    </b-navbar-item>

                    <b-navbar-item href="/#">
                        Change Password
                    </b-navbar-item>

                </b-navbar-dropdown>
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

        @yield('content')
        
    </div>
        
  

    <script>
        
    </script>

</body>

</html>
