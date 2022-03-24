@extends('main-page-layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="bg-image custom-bg-css">
            <div class="bg-transparent">
                <div class="col-12">
                    <div style="text-align:center" class="pt-sm-5 pb-sm-3">
                        <h4 style="font-size:40px;color:#000" class="main-heading">How to connect. Easy as 1, 2, 3.</h4>
                    </div>
                </div>
                <div class="col-12 mt-sm-5 pb-sm-5">
                    <div class="row">
                        <div class="col-sm-4 mt-4 mt-sm-0">
                            <div style="text-align:center" class="connectionUserIcon">
                                <h4><i class="fab fa-wpforms"></i></h4>
                                <h5>Fill out the registration form.</h5>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4 mt-sm-0">
                            <div style="text-align:center" class="connectionUserIcon">
                                <h4><i class="fas fa-user"></i></h4>
                                <h5 > Once admitted, complete your profile.</h5>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4 mt-sm-0">
                            <div style="text-align:center" class="connectionUserIcon">
                                <h4><i class="fab fa-connectdevelop"></i></h4>
                                <h5>Based on your profile, we will connect you with relevant entrepreneurs for mutually beneficial relationships.</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
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
@endpush
@push('styles')
<style>
    html, body{
        width:100%;
        height:100vh;        
    }
     .custom-bg-css{
     height: 90vh;
    }
    .bg-image{
        background-image: url("{{asset('home-style/images/bg-how-to-connect.jpg') }}");      
    }
    .bg-transparent{
        background: #6358585e!important;
        padding: 20px 0px;
    }
    .connectionUserIcon i {
        font-size: 75px;
        color: #fff;
    }
    .connectionUserIcon h5 {
        margin-top: 1rem;
        color: #fff;
    }

    @media screen and (max-width:767px){
        .connectionUserIcon h5{
            font-size: 18px;
            line-height: 22px;
            padding: 0 1rem!important;
        }
        .main-heading{
            font-size: 25px!important;
        }
        .bg-image{
            margin-top:0rem;
        } 
    }   
</style>
@endpush