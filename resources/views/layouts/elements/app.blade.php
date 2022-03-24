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
        <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('css/aos.css') }}">   
        <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">        
        <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/custom_style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/media_query.css') }}">
        <link rel="stylesheet" href="{{ asset('css/SimpleStarRating.css') }}">
        <link rel="stylesheet" href="{{ asset('css/star-rating-svg.css') }}">
        <script src="{{ asset('js/modernizr-custom.js') }}"></script>  
        <script src="{{asset('js/sweetalert2.all.min.js')}}"></script>        
        @stack('styles')
    </head>
    <body>
        @if(Route::currentRouteName() == 'home')  
        @if(!empty($adTop)) 
        @foreach($adTop as $dd)
        <div class="text-center" style="background: #8a888878">
            <a href="{{$dd->url}}" target="_blank">
                <img src="{{$dd->image}}" width="728px" height="90px">
            </a>
        </div>
        @endforeach
        @endif
        @endif

        @include('layouts.elements.navbar')
        <main class="">
            @yield('content')
        </main>       
        @include('layouts.elements.modal')
        @include('layouts.elements.footer')     

        <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('js/ajax.js') }}"></script>        
        <script src="{{ asset('js/toastr.min.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>        
        <script src="{{ asset('js/croppie.min.js') }}"></script>        
        <script src="{{ asset('js/select2.min.js') }}"></script>        
        <script src="{{asset('bootstrap/js/owl.carousel.min.js')}}"></script>  
        <script src="{{ asset('js/jquery.maskedinput-1.3.min.js') }}"></script>
        <script src="{{ asset('js/SimpleStarRating.js') }}"></script>
        <script src="{{ asset('js/jquery.star-rating-svg.js') }}"></script>
        
        <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        
        <script>
            $(function () {
                $('.company-contact-input').mask('(999) 999-9999');
            });
        </script>  
        <script>
            $(document).ready(function () {
                $(".js-multiple-product").select2({
                    placeholder: "--Select a product--",
                    allowClear: true
                });
                $(".js-multiple-industry").select2({
                    placeholder: "--Select a industry--",
                    allowClear: true
                });

            });
            var ratings = document.getElementsByClassName('rating');
            for (var i = 0; i < ratings.length; i++) {
                var r = new SimpleStarRating(ratings[i]);
                ratings[i].addEventListener('rate', function (e) {
                    console.log('Rating: ' + e.detail);
                });
            }
        </script>
        @stack('scripts')
        @if(Auth::id()!= "")
        @include('layouts.elements.chat')  
        @endif
    </body>
</html>
