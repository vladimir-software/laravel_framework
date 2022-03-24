@extends('layouts.elements.app')
@section('content')

<section class="sign-up-bg">
    <div class="container">
        <!--SURVEY-->
        <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
            <div class="card surveyBoxSize scale-up-center  mt-md-5 mt-2"> 
                <div class="card-header text-center bg-white">
                    <h4 class="text-center" style="color:#ff7c00!important">Reset Password</h4>
                   <!--<img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">-->
                </div>
                <div class="card-body" style="color:#333;">                   
                    <form method="post" action="{{route('password.passwordEmail')}}">                        
                        @csrf
                        @if ($message = Session::get('isSubmit'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong>  {{$message}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        <div class="px-5 text-center small">
                            <p>Enter your email address that you used to register. We'll send you an email with a link to reset your password.</p>
                        </div>
                        <div class="col-auto">
                            <!--<label class="sr-only" for="inlineFormInputGroup">Username</label>-->
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text bg-white"><i class="fas fa-envelope"></i></div>
                                </div>
                                <input type="email" name="reset_email" class="form-control emailInput" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email address" required="">
                            </div>
                        </div>
                        <div class ="uk-margin">
                            @if ($message = Session::get('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{$message}}
                            </div>
                            @endif
                        </div>
                        <div class="text-center my-4">                            
                            <button type="submit" class="btn btn-success text-uppercase py-2 px-5" style="font-size:12px;font-weight:600;letter-spacing:.5px;">Reset my password</button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')

<style>
    label {
        color: #00ab2c;
        margin-bottom: 0px;
        font-size: 14px;
    }
    .emailInput:focus{
        border: 1px solid #ced4da;
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
@endpush