<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('includes.head')
    </head>
    <body>
        @include('includes.header')

        <div id="page-content">
            @yield('content')
        </div>

        @include('includes.footer')
    </body>
</html>
