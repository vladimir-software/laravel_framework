@extends('layouts.elements.app')
@section('content')
<div class="container">
    <div class="row">      
        <div class="col-md-5  mx-auto mt-4">                         
            <div class="card" >               
                <div class="card-body">
                    <div class="success-container text-center d-none">
                        <h5 class="text-success">Success!</h5>
                        <p style="color:#000;">Your password has been changed successfully.</p>
                        <a href="{{route('login')}}" class="btn btn-success">Login</a>
                    </div>  

                    @if(empty($user['forget_hash']))
                    <div class="text-center">
                        <h5 class="text-danger">Error!</h5>
                        <p style="color:#000;">This link has expired.</p>
                        <a href="{{route('login')}}" class="btn btn-success">Login</a>
                    </div>  
                    @else
                    <div class="resetFormContainer">
                        <h5 class="text-center mb-4 newPasswordHeading" >Create your new password</h5>  
                        <form method="POST" action="javascript:void(0);" class="changeUserPassword">
                            @csrf
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                        </div>                                    
                                        <input type="text" readonly=""  name="email" value="{{$user['email']}}"  autocomplete="off" placeholder="Email Address" class="form-control border-left-0" value="">
                                    </div>  
                                    <small class="appendErrForPassword1" ></small> 
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input type="password"  name="password1"  autocomplete="off" placeholder="Password" id="primary-password"  class="form-control border-left-0">
                                    </div>  
                                    <small class="appendErrForPassword1" ></small> 
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <div class="input-group mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input type="password"  name="password2" autocomplete="off" class="form-control border-left-0" id="secondary-password" placeholder="Confirm Password" required="">
                                        <input type="hidden"  name="token"  class="form-control"  value="{{$token}}">
                                    </div>
                                    <small class="appendErrForPassword2" ></small> 
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12" >
                                    <div class="appendError">
                                    </div>                         
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-success text-white  py-2 px-5 createPasswordByUser"  style="width:100%;">Change Password</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    @if ( Session::get('status') == 'failed')
                                    <div class="uk-alert-success" uk-alert>
                                        <a class="uk-alert-close" uk-close></a>                                    
                                        <strong>{{ Session::get('message') }}</strong>                                   
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@push('scripts')
<style>
    .newPasswordHeading{
        color: #ff7c00;
        text-transform: capitalize;
        margin: 20px 0px;
        font-weight: 600;
    }
    @media only screen and (min-width: 1000px){   
        main{
            display: flex;
            width: 100%;
            justify-content: center;
            align-items: center;
            height: 89vh;
        }
    }
</style>

<style>
    .form-control:focus, .form-control:active {
        border-color: #ced4da;
    }
    @media (max-width: 800px) {
        .carousel-indicators li {           
            right: 90px!important;
        }         
    }  

    @media (min-width: 500px) {

        .carousel-inner{
            width: 500px;
            margin: auto;
            text-align: center;
        }
        .carousel-item{
            width: 250px;
        }
        .carousel-indicators .active{
            background-color:green;
        }
        .carousel-indicators li {
            background-color:#a5a4a9;
            right: 120px;
        }
        #carouselExampleIndicators{min-height: 50%};
    }  
    .input-group-text{
        background: transparent;
        padding-right:  0px!important;
    }
    .changeColor{
        color: #5020a3;
    }
</style>
<script>
    $(document).on('keyup', '#secondary-password', function () {
        $('.appendErrForPassword2').html('');
        $('.createPasswordByUser').prop('disabled', false);
    });

    $(document).on('submit', '.changeUserPassword', function () {
        if ($('#secondary-password').val() !== $('#primary-password').val()) {
            $('.appendErrForPassword2').html('');
            var myvar = '<div class="alert alert-danger"><strong>Alert! </strong>Your password and confirmation password do not match</div>';
            $('.appendErrForPassword2').append(myvar);
            $('.createPasswordByUser').prop('disabled', true);
            return false;
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/changeUserPassword",
            data: $(".changeUserPassword").serialize(),
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $('.resetFormContainer').addClass('d-none');
                    $('.success-container').removeClass('d-none');
                } else {
                    $('.resetFormContainer').removeClass('d-none');
                }
                ;
            }
        });
    });
</script>
<style>
    @media screen and (min-width:720px){
        .sign-up-bg{           
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .surveyBoxSize{
            max-height: 80vh;
            position: relative!important;
            overflow-y:scroll!important;
        }

    }
</style>
@endpush