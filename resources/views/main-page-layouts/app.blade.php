<!DOCTYPE html>
<html lang="en">
    <head>
        <title>ConnectEO</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" sizes="192x192" href="{{asset('/asset/connectEO_favicon.png')}}">

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet"> 
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">    
        <link rel="stylesheet" href="{{asset('main-page-layout/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('main-page-layout/css/animate.css')}}">  
        <link rel="stylesheet" href="{{asset('main-page-layout/css/owl.carousel.min.css')}}">  
        <link rel="stylesheet" href="{{asset('main-page-layout/css/custom_style.css')}}"> 
        <link rel="stylesheet" href="{{asset('main-page-layout/css/media_query.css')}}"> 
        <script src="{{asset('main-page-layout/js/jquery.min.js')}}"></script>
        <script src="//a.mailmunch.co/app/v1/site.js" id="mailmunch-script" data-mailmunch-site-id="802647" async="async"></script>
        <style>          
            a{
                text-decoration: none!important;
            }
        </style>   
        @stack('styles')
    </head>
    <body>

        @include('main-page-layouts.sidenav')
        @include('main-page-layouts.navbar')
        <main class="">
            @yield('content')
        </main>       
        @include('main-page-layouts.footer')  


        <script src="{{asset('main-page-layout/js/popper.min.js')}}"></script>
        <script src="{{asset('main-page-layout/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('js/jquery.maskedinput-1.3.min.js') }}"></script>
        <script src="{{ asset('main-page-layout/js/owl.carousel.min.js') }}"></script>
        <script>
            jQuery(function () {
                jQuery('.company-contact-input').mask('(999) 999-9999');
            });
        </script> 
        @stack('scripts')
    </body>
</html>
