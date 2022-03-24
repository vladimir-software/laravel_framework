<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png"  href="/asset/connectEO_favicon.png">
        <title>ConnectEO</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('css/demo.css') }}">
        <link rel="stylesheet" href="{{ asset('css/component.css') }}">

        <link rel="stylesheet" href="{{ asset('css/open-iconic-bootstrap.min.css') }}">
        <link rel="stylesheet" href="css/animate.css">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/aos.css') }}">     
        <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/owl.carousel.min.css')}}">

        <script src="{{ asset('js/modernizr-custom.js') }}"></script>   
        @stack('styles')
    </head>
    <body>
        @include('layouts.elements.navbar')
        <main class="">
            @yield('content')
        </main>       
        @include('layouts.elements.modal')
        @include('layouts.elements.footer')     

        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
        <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/aos.js') }}"></script>
        <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
        <script src="{{ asset('js/scrollax.min.js') }}"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>        
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>        
        <script src="{{asset('bootstrap/js/owl.carousel.min.js')}}"></script>     
        @stack('scripts')

    </body>
</html>