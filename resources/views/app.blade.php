<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <!-- Fonts -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

          @if (Auth::check())
        <script>
            window.Laravel = {!! json_encode([
                'isLoggedin' => true,
                'user' => Auth::user(),
            ]) !!}
        </script>
    @else
        <script>
            window.Laravel = {!! json_encode([
                'isLoggedin' => false,
            ]) !!}
        </script>
    @endif
    <div id="app">

    </div>
   

</body>

</html>
