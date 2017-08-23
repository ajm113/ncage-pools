<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('includes.head')
    </head>
    <body>
        @include('includes.header')
        @yield('content')
        @include('includes.footer')
    </body>
</html>
