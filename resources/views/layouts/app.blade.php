<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }} @yield('title')</title>
    @include('layouts.partials._head')
</head>
<body>
    @include('layouts.partials._nav')
    <div id="app">
        <div class="container">
            @yield('content')
        </div>
    </div>
    @include('layouts.partials._footer')
</body>
</html>
