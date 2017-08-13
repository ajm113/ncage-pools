<?php
    $title = (isset($title)) ? $title : 'Untitled'; // For some reason if we forget to set this.
?>
<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('includes.head', ['title' => $title])
    </head>
    <body>
        @include('includes.header')

        <div id="page-content">
            @yield('content')
        </div>

        @include('includes.footer')
    </body>
</html>
