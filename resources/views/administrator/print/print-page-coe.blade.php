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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>

        @page {
            size: A4;
        }

        @media print {
            .coe {
                break-inside: avoid;
            }

            button {
                visibility: hidden;
            }
        }

        html{
            font-size: 12px;
        }

        .columns{
            margin-bottom: 5px;
        }
        .img-header{
            height: 120px;
            display: block;
            margin: auto;
        }

        .img-footer{
            height: 50px;
            margin: 0;
        }
        

        hr{
            margin: 3px;
        }

        .coe{
            width: 816px;
            margin: auto;
            margin-bottom: 10px;
        }

        .student-info{
            display: flex;
        }

       
   
        
    </style>
</head>

<body>
    
    <div id="app">
        <coe-page :prop-data='@json($students)'></coe-page>
    </div>

</body>

</html>
