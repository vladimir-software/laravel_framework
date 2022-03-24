<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <link rel="icon" type="image/png"  href="/asset/connectEO_favicon.png">
        <title>ConnectEO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        @stack('styles')
        <script src="//a.mailmunch.co/app/v1/site.js" id="mailmunch-script" data-mailmunch-site-id="802647" async="async"></script>
    </head>
    <body>
        <main class="">
            @yield('content')
        </main>
        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js') }}"></script>
    </body>
</html>
