@extends('main-page-layouts.app')
@section('content')
<div class="container-fluid pricing">
    <div class="row">
        <div class="bg-image custom-bg-css"> 
            <div class="col-12">
                <div class="row cardAnimation">
                    <div class="col-md-4 cardAnimation-1">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Basic/Free</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$0</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>See compatible matches.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Messaging capabilities. </li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Rate businesses.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul>                                 
                                <a href="{{route('signup')}}" class="btn btn-block btn-primary">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cardAnimation-1">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Premium</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$45</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">                                    
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li class="text-muted"><span class="fa-li"><i class="fas fa-times"></i></span>Promote your business. </li>
                                </ul>
                                <a href="{{route('signup')}}" class="btn btn-block btn-primary chooseSubscription" rel="2">Get Started</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 cardAnimation-1">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted text-uppercase text-center">Platinum</h5>
                                <h6 class="card-price text-center"><span class="subscriptionPrice">$99</span><span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Create your business profile. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Be seen by other users.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Get notified on matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Interact with matches who connect with you. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>See compatible matches.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Messaging capabilities. </li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Rate businesses.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Manage projects.</li>
                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>Promote your business. </li>
                                </ul>
                                <input type="hidden" value="2"  class="subscribedPlan">
                                <a href="{{route('signup')}}" class="btn btn-block btn-primary chooseSubscription" rel="3">Get Started</a>
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
        });
        $('.cardAnimation-1').addClass('fadeInUp');
    });

</script>
@endpush
@push('styles')
<style>
    .bg-image{
        background-image: url("{{asset('home-style/images/bg-how-to-connect.jpg') }}");
    }
    html, body{
        width:100%;
        height:100vh;        
    }
    .custom-bg-css{
        padding: 50px 10px;
    }
  
    .fadeInUp{
        position: relative;
        -webkit-animation-duration: 2s;  /* Safari 4.0 - 8.0 */      
        animation-duration: 2s;  
    } 
    .fadeInUp:nth-of-type(2){
        position: relative;
        -webkit-animation-duration: 2s;  /* Safari 4.0 - 8.0 */      
        animation-duration: 2s;
        animation-delay: .2s;
    } 
    .fadeInUp:nth-of-type(3){
        position: relative;
        -webkit-animation-duration: 2s;  /* Safari 4.0 - 8.0 */      
        animation-duration: 2s; 
        animation-delay: .4s;
    } 

</style>
@endpush