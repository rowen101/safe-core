<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Safexpress<title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="hold-transition login-page" >
    <div id="login">
    <Login />
    </div>
</body>

</html>
