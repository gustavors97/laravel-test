<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Laravel Test for VAITEL">
        <meta name="author" content="Gustavo Rodrigues Silva - http://gustavors.com">
        <meta name="keywords" content="Test, Laravel, VueJS">
        <meta name="theme-color" content="#00A9E9"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="#00A9E9"/>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="img/favicon.png" rel="shortcut icon">

        <title>{{ config('app.name', 'LARAVEL TEST') }} - @yield('title')</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/npm/main.css') }}" media="all">

        @yield('css')

        @stack('scripts_head')
    </head>

    <body>

        <main id="app">
            @yield('content')
        </main>

        <script src="{{ mix('js/npm/main.js') }}"></script>
        <script src="{{ mix('js/npm/components.js') }}"></script>
        <script src="{{ asset('js/custom/site_vue.js') }}"></script>
        
        @yield('scripts')

        @stack('scripts')

    </body>

</html>
