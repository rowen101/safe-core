<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/app/adminlte.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/app/ionicons.min.css') }}" />
     <!-- Google Font: Source Sans Pro -->
     <link rel="stylesheet"
     href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Scripts -->

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini">

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

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('backend/js/app/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/app/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/app/adminlte.min.js') }}"></script>
    <script src="{{ asset('backend/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

</body>

</html>
