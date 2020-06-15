<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script rel="prefetch">
        window.data = {
            csrfToken: '{{csrf_token()}}',
            errors: JSON.parse('{!! $errors->toJson() !!}'),
            session: JSON.parse('{!! json_encode(session()->only(array_merge(FlashStatus::getValues(), ['_flash']))) !!}'),
        };
    </script>

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
</head>
<body>
<div id="app">
    @include('layouts.menu')

    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script  rel="preload" src="{{ asset(mix('js/app.js')) }}"></script>
@yield('js')
</body>
</html>
