<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Scripts -->

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <main id="app" style="margin: 0px; width: 100%;">
        <nav class="navbar navbar-dark bg-primary d-flex justify-content-center">
            <h3>Pemetaan Persebaran Penyakit Diabetes Militus</h3>
        </nav>
        <app></app>
    </main>

    <script src="{{ mix('/js/app.js') }}"></script>
</body>

</html>