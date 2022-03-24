@extends('main-page-layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 mx-auto contactUsCard" style="margin-top:5.5rem">               
            <div class="card shadow-none border-0 contactPageCard my-sm-4">
                <div class="card-body">
                    <div class="text-center py-4"><h2 style="color:#ff7c00" class="contact-main-heading"><b>Get In Touch!</b></h2>
                        <p class="contact-para">Send us a message and we'll get back to you promptly!</p>
                    </div> 
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{$message}}
                        </div>
                    @endif
                    @if($errors->any())                
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                           <strong>Error:</strong> <span>{{$errors->first()}}</span>
                        </div>
                    @endif
                    <form id="contact-form" method="post" action="{{route('submitContactUs')}}" role="form">   
                        @csrf
                        <div class="controls text-left">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_name">First Name</label>
                                        <input id="form_name" type="text" name="name" class="form-control" required="required" data-error="Firstname is required.">
                                        <div id="name_field_error" class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_lastname">Last Name</label>
                                        <input id="form_lastname" type="text" name="surname" class="form-control"  required="required" data-error="Lastname is required.">
                                        <div id="surname_field_error" class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_email">Email</label>
                                        <input id="form_email" type="email" name="email" class="form-control" required="required" data-error="Valid email is required.">
                                        <div id="email_field_error" class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="form_phone">Phone</label>
                                        <input id="form_phone" type="tel" name="phone" class="form-control company-contact-input">
                                        <div id="tel_field_error" class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="form_message">Message</label>
                                        <textarea id="form_message" name="message" class="form-control"  rows="4" required data-error="Please,leave us a message."></textarea>
                                        <div id="message_field_error" class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mt-2 mb-4">
                                    <button class="g-recaptcha btn btn-success btn-send py-2 my-3 w-50" data-sitekey="6LfWuc8ZAAAAAHvVxZJzwd7dpPi0xCRmKLomReO-" data-callback='onSubmit' data-action='submit'>Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://www.google.com/recaptcha/api.js"></script>
<script type="text/javascript">

   function onSubmit(token) {
    var form = document.getElementById('contact-form');
    document.getElementById('name_field_error').innerHTML = '';
    document.getElementById('surname_field_error').innerHTML = '';
    document.getElementById('email_field_error').innerHTML = '';
    document.getElementById('tel_field_error').innerHTML = '';
    document.getElementById('message_field_error').innerHTML = '';
    for(var i=0; i < form.elements.length; i++){
      if(form.elements[i].value === '' && form.elements[i].hasAttribute('required')) {
      
        if (form.elements[i].name == 'name') document.getElementById('name_field_error').innerHTML = '* Required';
        if (form.elements[i].name == 'surname') document.getElementById('surname_field_error').innerHTML = '* Required';
        if (form.elements[i].name == 'email') document.getElementById('email_field_error').innerHTML = '* Required';
        if (form.elements[i].name == 'phone') document.getElementById('tel_field_error').innerHTML = '* Required';
        if (form.elements[i].name == 'message') document.getElementById('message_field_error').innerHTML = '* Required';
        return false;
      }
    }
     document.getElementById("contact-form").submit();
   }

    jQuery(document).ready(function () {
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() >= 100) {
                jQuery("#main-navbar").addClass("navbar-sticky");
                jQuery('.logoForDesktop img').addClass('logoDesktopStyle');
                jQuery('.navbar-nav').css('align-items', 'center');               
                jQuery('.navbars').css('top', '0px');
            } else {
                jQuery("#main-navbar").removeClass("navbar-sticky");
                jQuery('.logoForDesktop img').removeClass('logoDesktopStyle');
                jQuery('.navbar-nav').css('align-items', 'unset');
                jQuery('.navbars').css('top', '-15px');
            }
        })
    });
</script>
<style>
    .content {
        margin-top: 7rem;
    }
    
    .btn-success{
        background: #ff7c00!important;
        border: #ff7c00!important;
    }
    
    .contactPageCard{
        border-radius:10px;
        background-color: #f8f8f8!important;
    }
    
    .with-errors {
        color:red;
    }
    
    label{
        color: #000!important;
        margin-bottom: 0px!important;
        font-size: 14px;
    }
    
    .contactPageCard .contact-main-heading{
        font-family: 'Karla', sans-serif;
        font-size: 68px;
        line-height: 64px;
        font-weight: 700;
        letter-spacing: -1px;
        text-transform: none;
    }
    
    .contact-para{
        font-family: "Karla", sans-serif;
        font-size: 16px;
        line-height: 25px;
        font-weight: 400;
        color: #999999;
    }
    
    @media only screen and (max-width: 480px){
        .contact-main-heading {
            font-size: 22px!important;
        }
        .contactUsCard {
            margin-top: 0!important;
            padding: 0px;
        }
    }
</style>
@endpush
