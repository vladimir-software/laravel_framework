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
                        <form  method="post" action="javascript:void(0);" id="signUpForm" class="Form">
                            @csrf
                            <div class="form-group">                               
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user" style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="text" autocomplete="off" name="fullname" class="form-control" placeholder="Full Name" required="">
                                </div>
                            </div>

                            <div class="form-group">                               
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-building" style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="text"  name="company_name" class="form-control" placeholder="Company Name" required="" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">                                
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-envelope" style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="email" autocomplete="off" name="email" class="form-control" placeholder="Email Address" required="">
                                </div>
                            </div>
                            <div class="form-group">                               
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock" style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="password" autocomplete="off" name="password" class="form-control" id="pass1" placeholder="Choose password" required="">                                    
                                </div>
                            </div> 
                            <div class="form-group" id="passwordCheck" style="display:none;">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <i class="fa fa-exclamation-circle" aria-hidden="true" style='color:pink;'></i>
                                    </div>
                                    <div>Your password needs to be at least 8 characters including a lower-case letter, an upper-case letter, a number and one special character (!@#$%^&*)</div>
                                </div>
                            </div> 
                            <div class="form-group">                              
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock" style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="password" autocomplete="off" name="confirm_password" class="form-control" id="pass2" placeholder="Confirm password" required="">
                                </div>
                            </div> 
                            <div class="form-group">                              
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend ">
                                        <div class="input-group-text bg-white border-0">
                                            <i class="fas fa-tag" style="font-size: 28px;opacity:1"></i> 
                                        </div>
                                    </div>
                                    <input type="text" name="promo_code" autocomplete="off" class="form-control checkPromoCode" id="pass2" placeholder="Promo code (optional)" value="">
                                    <span style="display: flex;align-items: center;"><i class="far fa-check-circle  d-none matchedPromoCode matched-success"></i><i class="unMatchedPromoCode d-none fas fa-times-circle text-danger"></i></span>
                                </div>
                            </div> 
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
                        <div class="row">
                            <div class="col-md-12 pb-3 " id="socialButtonContainer">
                                <a class="btn btn-block btn-social btn-facebook text-center" href='{{$loginUrl}}'>
                                    <i class="fab fa-facebook-f"></i> Sign Up with Facebook
                                </a>
                            </div>
                        </div>  
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
    .matched-success{
        color: #28a745;
    }

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
    @media (max-height:640px){
        .card{
            top: 0%!important;
        }
    }
    body {
        background-image: url('asset/sign-up.jpeg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;
    }

</style>
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }

    $( document ).ready(function() {
        $("#pass1").focusout(function() {
            $("#passwordCheck").hide();
            var passwordValue = $(this).val();
            var paswd =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,50}$/;
            if(passwordValue.match(paswd)) { 
                console.log('password accepted');
            } else { 
                $("#passwordCheck").show();
                console.log('Your password needs to be at least 8 characters including a lower-case letter, an upper-case letter, a number and one special character (!@#$%^&*)');
            }
        });
    });

    $(document).on('keyup', '.checkPromoCode', function () {
        if ($(this).val() == 'CONNECTEO') {
            $('.matchedPromoCode').removeClass('d-none');
            $('.unMatchedPromoCode').addClass('d-none');
        } else if ($(this).val() == '') {
            $('.unMatchedPromoCode').addClass('d-none');
            $('.matchedPromoCode').addClass('d-none');
        } else {
            $('.unMatchedPromoCode').removeClass('d-none');
            $('.matchedPromoCode').addClass('d-none');
        }

    });
</script>
@endpush
