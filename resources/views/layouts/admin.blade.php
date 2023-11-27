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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&family=Manrope:wght@200;300;400;700&family=Poppins&family=Roboto+Condensed:wght@300;400;500;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            font-family: 'Josefin Sans', sans-serif;
            font-family: 'Manrope', sans-serif;
            font-family: 'Poppins', sans-serif;
            font-family: 'Roboto', sans-serif;
            font-family: 'Roboto Condensed', sans-serif;
        }
    </style>
</head>

<body>
    
    <div id="app">
        
        <b-navbar>
            <template #brand>
                <b-navbar-item>
                    <img src="/img/tcnhs_logo.png" />
                    @auth()
                        {{ Auth::user()->role }}
                    @else
                        ENSYS
                    @endauth
                </b-navbar-item>
            </template>
    
            <template #start>
               
    
            </template>
    
            <template #end>
                
                <b-navbar-item href="/admin-home">
                    Home
                </b-navbar-item>

                <b-navbar-dropdown label="Settings">

                    <b-navbar-item href="/academic-years">
                        Academic Years
                    </b-navbar-item>

                    <b-navbar-item href="/tracks">
                        Tracks
                    </b-navbar-item>
                    <b-navbar-item href="/strands">
                        Strands
                    </b-navbar-item>
                    <b-navbar-item href="/sections">
                        Sections
                    </b-navbar-item>
                    <b-navbar-item href="/courses">
                        Subjects
                    </b-navbar-item>
                 

                </b-navbar-dropdown>

                <b-navbar-item href="/manage-learners">
                    Learners
                </b-navbar-item>

                <b-navbar-item href="/enrollee">
                    Enrollee
                </b-navbar-item>

                <b-navbar-item href="/users">
                    Users
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

        @yield('content')
        
    </div>

    <script>
        
    </script>

</body>

</html>
