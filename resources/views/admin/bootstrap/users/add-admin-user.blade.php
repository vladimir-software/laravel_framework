@extends('admin.bootstrap.layouts.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-9 col-12 mx-auto">
                <div class="card my-2">
                    <div class="card-body">
                    @if($userAdded)
                        <div class="text-center">
                            <h3 class="dark-grey-text mb-3">
                                <strong>Admin User Created</strong><br/><br/>
                                <button onclick="window.location.href='/admin/dashboard'" type="button" class="btn btn-dark blue-gradient btn-block z-depth-1a waves-effect waves-light" id="ok-btn" style="letter-spacing: 1px !important;" >OK</button>
                            </h3>
                        </div>                     
                    @endif
                    @if(!$userAdded)
                        <div class="text-center">
                            <h3 class="dark-grey-text mb-3">
                                <strong>Create Admin User</strong>
                            </h3>
                        </div>                     
                        <form method="post" action="/admin/add-admin-user" id="signUpForm" class="Form">
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
                                        <div class="input-group-text"><i class="fas fa-user-circle " style="font-size: 28px;"></i></div>
                                    </div>
                                    <input type="text" autocomplete="off" name="username" class="form-control" placeholder="Username" required="">
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="appendError">
                                    </div>                         
                                </div>
                            </div> 
                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-dark blue-gradient btn-block z-depth-1a waves-effect waves-light" id="signup-btn" style="letter-spacing: 1px !important;" >Create Account</button>
                            </div> 
                            @if($error)
                              <div style="color:red;">Error: {{$error}}</div>
                            @endif                                  
                        </form>
                    </div>
                    @endif
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
</script>
@endpush
