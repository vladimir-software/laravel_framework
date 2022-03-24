@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-5 col-sm-10 mx-auto my-3">        
                <div class="card">
                    <div class="card-header d-md-none text-center bg-white">
                        <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                    </div>
                    <div class="card-body" style="padding:2.25rem!important">
                        <div class="text-center d-none d-md-block">
                            <h3 class="dark-grey-text mb-5">
                                <strong>Sign In</strong>
                            </h3>
                        </div>  
                        <div class="alert alert-danger errorForApproval" role="alert" style="display: none"></div>
                        <div class=" text-center d-md-none">
                            <h4 class="dark-grey-text mb-3">Sign in</h4>
                        </div>                     
                        <form  method="post" action="javascript:void(0);" id="loginForm" class="Form"> 
                            @csrf
                            <div class="form-group">                              
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email Address" required="">
                            </div>
                            <div class="form-group mb-0">                               
                                <input type="password" name="password" class="form-control" id="loginPassword" placeholder="Your Password" required="">
                                <div class="text-right mr-4 ">
                                    <i class="fas fa-eye prefix showHidePassword" style="font-size: 1rem!important;color: #ff7c00!important;"></i>
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="form-check" style="display: flex;flex-direction: row;">
                                    <div>
                                        <input class="form-check-input" style="margin-top:9px;height: 11px;" type="checkbox" name="remember" value="" id="defaultCheck1" {{ old('remember') ? 'checked' : '' }}>
                                               <label class="form-check-label small" for="defaultCheck1" style="margin-top: -1px;font-size:11px;">
                                            Keep me logged in
                                        </label>
                                    </div>
                                    @if (Route::has('password.reset-password'))
                                    <a class="btn btn-link ml-auto pr-0" style="font-size: 11px;margin-top: 4px;" href="{{ route('password.reset-password') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div> 
                            </div> 
                            <div class="appendError">
                            </div> 
                            <div class="text-center">
                                <button type="submit" class="btn blue-gradient text-white btn-block z-depth-1a waves-effect waves-light" id="signin-btn">Sign In</button>
                            </div>                            
                        </form>
                        <div class="row">
                            <div class="col-md-12 py-3 " id="socialButtonContainer">
                                <a class="btn btn-block btn-social btn-facebook text-center" href='{{$loginUrl}}'>
                                    <i class="fab fa-facebook-f"></i> Sign In with Facebook
                                </a>
                            </div>
                        </div> 
                        <div>
                            <p class="small d-flex justify-content-center text-dark">Don't have an account?
                                <a href="{{route('signup')}}" class="blue-text ml-1"  onMouseOver="this.style.textDecoration = 'underline'"
                                   onMouseOut="this.style.textDecoration = 'none'"> Sign up here</a>
                            </p> 
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@push('scripts')
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
    $(document).on("click", ".showHidePassword", function () {
        //<i class="fas fa-eye-slash"></i>
        if ($("#loginPassword").prop("type") == 'password') {
            $('.showHidePassword').removeClass('fa-eye').addClass('fa-eye-slash');
            $("#loginPassword").prop("type", "text");
        } else {
            $('.showHidePassword').removeClass('fa-eye-slash').addClass('fa-eye');
            $("#loginPassword").prop("type", "password");
        }
    });

</script>
<style>
    html, body {
        height: 100%;

    }
    @media (max-height:640px){
        .card{
            top: 0%!important;
        }
    }
    ::placeholder{
        font-size: 14px;
    }
    .loginContainer{
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width:700px){
        .sign-up-bg {
            min-height: 86vh;
            display: flex;
            align-items: center;
            justify-content: center;
            /*width: 100%;*/
        }
    }

</style>
@endpush


@endsection
