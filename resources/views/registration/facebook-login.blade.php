@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-9 col-12 mx-auto">
                <div class="card my-2">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="dark-grey-text mb-3">
                                <strong>Sign Up</strong>
                            </h3>
                        </div>                     
                        <form  method="post" action="{{route('facebookSignup')}}" id="signUpForm" class="Form" > 
                            @csrf
                            <input type="hidden" name="facebook-id" class="form-control" readonly="" value="{{isset($fb_user_data['id'])? $fb_user_data['id'] :""}}">
                            <div class="form-group">                               
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user" style="font-size: 28px;"></i></div>
                                    </div>
                                    @if(isset($fb_user_data['email']) && isset($fb_user_data['email']) != "")
                                    <input type="text" name="fullname" class="form-control" readonly="" placeholder="Full Name" required="" value="{{isset($fb_user_data['name'])? $fb_user_data['name'] :""}}">
                                    @else
                                    <input type="text" name="fullname" class="form-control" placeholder="Full Name" required="">
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">                                
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-envelope" style="font-size: 28px;"></i></div>
                                    </div>
                                    @if(isset($fb_user_data['email']) && isset($fb_user_data['email']) != "")
                                    <input type="email" name="email" class="form-control" readonly="" placeholder="Email Address" required="" value="{{isset($fb_user_data['email'])? $fb_user_data['email'] :""}}">
                                    @else
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" required="">
                                    @endif
                                </div>
                            </div>
                            <!-- <        div class="form-group">               
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text"><i class="fas fa-lock" style="font-size: 28px;"></i></div>
                                                                </div>
                                                                <input type="password" name="password" class="form-control" id="pass1" placeholder="Choose password" required="">
                            
                                                            </div>
                                                        </div> 
                                                        <div class="form-group">                              
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-lock" style="font-size: 28px;"></i></div>
                            </div>
                                                         <input type="password" name="confirm_password" class="form-control" id="pass2" placeholder="Confirm password" required="">
                            
                                                            </div>
                                                        </div> -->
                            <div>
                                <p style="font-size: 12px;text-align: center;margin: 0;">
                                    By signing up, you agree to our 
                                    <a href="{{route('terms_of_use')}}" target="_blank">Terms of Use.</a></p>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="appendError">
                                    </div>                         
                                </div>
                            </div> 
                            <div class="text-center mb-3">
                                <button type="submit" class="btn blue-gradient text-white btn-block  z-depth-1a waves-effect waves-light" id="signup-btn" style="letter-spacing: 1px !important;" >Sign Up</button>
                            </div>                           
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<style>
    .form-group .input-group-text{
        border: none;
        background: transparent;
    }
    html, body {
        height: 100%;

    }
    @media (max-height:640px){
        .card{
            top: 0%!important;
        }
    }

    body {
        /* Location of the image */
        background-image: url('asset/sign-up.jpeg');

        /* Background image is centered vertically and horizontally at all times */
        background-position: center center;

        /* Background image doesn't tile */
        background-repeat: no-repeat;

        /* Background image is fixed in the viewport so that it doesn't move when 
           the content's height is greater than the image's height */
        background-attachment: fixed;

        /* This is what makes the background image rescale based
           on the container's size */
        background-size: cover;

        /* Set a background color that will be displayed
           while the background image is loading */
        background-color: #464646;
    }

</style>
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>
<style>
    ::placeholder{
        font-size: 14px;
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