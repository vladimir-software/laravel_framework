<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Required meta tags -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png"  href="/asset/connectEO_favicon.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">      
        <title>ConnectEO</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.0/css/simple-line-icons.css" integrity="sha256-q5+FXlQok94jx7fkiX65EGbJ27/qobH6c6gmhngztLE=" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{asset('bootstrap/css/style.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.min.css')}}">
    <body>
        <div class="container-scroller">
            @include('admin.bootstrap.layouts.navbar')
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <div class="row row-offcanvas row-offcanvas-right">
                    @include('admin.bootstrap.layouts.sidenav')
                    <div class="content-wrapper">
                        @yield('content')
                        @include('admin.bootstrap.layouts.footer')
                    </div>
                </div>
            </div>
        </div>
        <!-- plugins:js -->
        <script src="{{asset('bootstrap/js/jquery.min.js')}}" ></script>        
        <script src="{{asset('bootstrap/js/popper.min.js')}}" ></script>
        <script src="{{asset('bootstrap/js/bootstrap.min.js')}}" ></script>
        <script src="{{asset('bootstrap/js/Chart.min.js')}}"></script>
        <script src="{{asset('bootstrap/js/off-canvas.js')}}"></script>
        <script src="{{asset('js/sweetalert2.all.min.js')}}"></script>
        <script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('bootstrap/js/owl.carousel.min.js')}}"></script>

        <script src="{{asset('bootstrap/js/dashboard.js')}}"></script>
        <script src="{{asset('bootstrap/js/Chart.min.js')}}"></script>
        <script src="{{ asset('js/jquery.maskedinput-1.3.min.js') }}"></script>    
        <script src="{{ asset('js/select2.min.js') }}"></script>

        <!-- End custom js for this page-->
        <script>
            $(document).ready(function () {
                $('.company-contact-input').mask('(999) 999-9999');
            });
            $(".datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                autoclose: true
            });
        </script>
        @stack('scripts')
    </body>
</html>
