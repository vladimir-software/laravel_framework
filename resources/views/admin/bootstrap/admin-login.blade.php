<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Required meta tags -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png"  href="/asset/fevicon-connectEO.png">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">      
        <title>ConnectEO</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
        <link rel="stylesheet" href="{{asset('bootstrap/css/materialdesignicons.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/flag-icon.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/vendor.bundle.base.css')}}">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/fontawesome-stars.css')}}">
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/style.css')}}">
        <!-- endinject -->
        <link id="avast_os_ext_custom_font" href="chrome-extension://eofcbnmajmjmplflapaojjnihcjkigck/common/ui/fonts/fonts.css" rel="stylesheet" type="text/css"><style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
    <style>
        @media(min-width: 700px){
            .contentCenter{
                position: relative;
                top: 15%;
            }
        }
    </style>
    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper">
                <div class="row">
                    <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-full-bg" style="background: url('{{asset("bootstrap/asset/login_1.jpg")}}');
                         background-size: cover;">
                        <div class="row w-100 contentCenter">
                            <div class="col-lg-4 mx-auto">
                                <div class="auth-form-dark text-left p-5">
                                    <h2>Login</h2>
                                    <h4 class="font-weight-light">Hello! let's get started</h4>
                                    <form class="pt-5" method="post" action="{{ route('admin.login.submit') }}"> 
                                        @csrf
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Username</label>
                                            <!--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="">-->
                                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="off" autofocus>
                                            <i class="fas fa-user"></i>
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-1">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                            <i class="fas fa-lock"></i>
                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        @if($message = Session::get('error'))
                                        <p class="text-danger">{{$message}}</p>
                                        @endif
                                        <div class="mt-5">
                                            <button type="submit" class="btn btn-block btn-warning btn-lg font-weight-medium">Login</button>
                                        </div>
                                        <div class="mt-3 text-center"> @if (Route::has('password.request'))
                                            <a class="btn btn-link auth-link text-white" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                            @endif
                                        </div>                 
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- content-wrapper ends -->
                    </div>
                    <!-- row ends -->
                </div>
                <!-- page-body-wrapper ends -->
            </div>
        </div>

            <!-- plugins:js -->
            <script src="{{asset('bootstrap/js/vendor.bundle.base.js')}}"></script>
            <script src="{{asset('bootstrap/js/vendor.bundle.base.js')}}"></script>
            <!-- endinject -->
            <!-- Plugin js for this page-->
            <script src="{{asset('bootstrap/js/jquery.barrating.min.js')}}"></script>
            <script src="{{asset('bootstrap/js/Chart.min.js')}}"></script>
            <script src="{{asset('bootstrap/js/raphael.min.js')}}"></script>
            <script src="{{asset('bootstrap/js/morris.min.js')}}"></script>
            <script src="{{asset('bootstrap/js/jquery.sparkline.min.js')}}"></script>
            <!-- End plugin js for this page-->
            <!-- inject:js -->
            <script src="{{asset('bootstrap/js/off-canvas.js')}}"></script>
            <script src="{{asset('bootstrap/js/hoverable-collapse.js')}}"></script>
            <script src="{{asset('bootstrap/js/misc.js')}}"></script>
            <script src="{{asset('bootstrap/js/settings.js')}}"></script>
            <script src="{{asset('bootstrap/js/todolist.js')}}"></script>
            <!-- endinject -->
            <!-- Custom js for this page-->
            <script src="{{asset('bootstrap/js/dashboard.js')}}"></script>
            <script src="{{ asset('js/jquery.maskedinput-1.3.min.js') }}"></script>
            <!-- End custom js for this page-->
            <script>
                $(document).ready(function () {
                    $('.company-contact-input').mask('(999) 999-9999');
                });
            </script>
            @stack('scripts')
    </body>
</html>
