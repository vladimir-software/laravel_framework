@extends('main-page-layouts.app')
@section('content')
<div class="container-fluid firstContainer">
    <div class="row">
        <div id="demo" class="carousel slide" data-ride="carousel" data-interval="5000">
            <ul class="carousel-indicators">
                <li data-target="#demo" data-slide-to="0" class="active"></li>
                <li data-target="#demo" data-slide-to="1"></li>
                <li data-target="#demo" data-slide-to="2"></li>
            </ul>

            <!-- The slideshow -->
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{asset('home-style/images/top-carousel-1.jpg')}}" alt="Los Angeles">
                    <div class="carousel-caption">
                        <h3 class="">The Best Connections<br>Are Made Here.</h3>
                        <p>A collaborative network of like-minded entrepreneurs.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('home-style/images/top-carousel-2.jpg')}}" alt="Chicago">
                    <div class="carousel-caption">
                        <h3>Curated List of Entrepreneurs<br> Made Just for You.</h3>
                        <p>Let our unique algorithm create your connections.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{asset('home-style/images/top-carousel-3.jpg')}}" alt="New York">
                    <div class="carousel-caption">
                        <h3 class="mb-md-0">Everything You Need to<br> Grow Your Business.</h3>
                        <p class="pt-1 mt-0 pb-2 text-center d-none d-md-block">
                            <a href="{{'signup'}}"  class="signupbutton small p-3 ">Start Connecting</a>
                        </p>
                        <p style="margin-top:26px!important;" class="d-md-none hideForDesktop">
                            <a href="{{'signup'}}"  class="signupbutton">Start Connecting</a>
                        </p>

                    </div>
                </div>
            </div>
            <div class="arrows">                        
                <a class="left-arrow"  href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="right-arrow" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 secondContainer">
    <div class="row">
        <div class="col-12 col-md-7 ">
            <img src="{{asset("asset/sketch-file-min.jpg")}}" width="100%" class="welcomeSlide">                   
        </div>
        <div class="col-md-5 ">                 
        </div>
        <div class=" col-12 col-md-9 offset-md-3">
            <div class="welcomeNetwork">
                <img src="{{asset("home-style/images/AdobeStock_89404153-min.jpg")}}"  height="auto;" width="100%">                       
            </div>
        </div>
        <div class="col-sm-9 offset-sm-1 col-sm-pull-2">
            <div class="welcomeContent">
                <h2 class="">Welcome to ConnectEO Network</h2>
                <p class="mt-3">A vetted community that connects entrepreneurs to opportunities. We create sustainable businesses by providing a safe space for entrepreneurs to collaborate with like-minded creators to expand their businesses, help others with their businesses and build meaningful, revenue-generating relationships. We do the work for you so all you need to do is connect!</p>
                <a href="{{route('signup')}}" class="btn btn-outline-primary startFreeButton">Start Free</a>                  
            </div>
        </div>
    </div>
</div>
<div class="container-fluid thirdContainer mb-5">
    <div class="row">
        <div class="col-sm-12">
            <div style="text-align:center">
                <h4 style="font-size:40px;color:#ffffff">Let Us Grow Your Network</h4>
            </div>
        </div>               
    </div>
    <div class="row mt-5">
        <div class="col-sm-4 connectionUserContainer">
            <div style="text-align:center" class="connectionUserIcon">
                <h4><i class="far fa-user"></i></h4>
                <h5 style="margin:15px 0">Collaborate with other entrepreneurs</h5>
            </div>
        </div>
        <div class="col-sm-4 connectionUserContainer ">
            <div style="text-align:center" class="connectionUserIcon">
                <h4> <i class="far fa-comments"></i></h4>
                <h5 style="margin:15px 0">Obtain the services you need to be successful</h5>
            </div>
        </div>
        <div class="col-sm-4 connectionUserContainer">
            <div style="text-align:center" class="connectionUserIcon">
                <h4><i class="far fa-handshake"></i></h4>
                <h5 style="margin:15px 0">Provide business services to help other entrepreneurs reach success</h5>
            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-12 col-md-7 "> </div>
        <div class="c0l-12 col-md-5 "> 
            <img src="{{asset("home-style/images/home-img-5.png")}}" width="100%"> 
        </div>
        <div class=" col-12 col-md-9">
            <div class="contactImage" style="margin-top: -30% !important;">
                <img src="{{asset("home-style/images/AdobeStock_208879443-min.jpeg")}}"  height="auto;" width="100%">                       
            </div>
            <div class="float-right contactContent mb-3">
                <h2 class="" style="font-size: 53px;">Contact Us</h2>
                <p class="mt-3">Feel free to contact us with any questions!</p>
                <a  href="{{route('side_menu_items.contact_us')}}" target="_blank" class="btn btn-outline-primary startFreeButton contactUsHeading">Contact Us</a>                  
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    jQuery(document).ready(function () {// .logoForDesktop img
        jQuery(window).scroll(function () {
            if (jQuery(window).scrollTop() >= 700) {
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
    $('.carousel').carousel({})
    $(function () {
        $(window).scroll(function () {
            var aTop = $('.carousel').height();
            var bTop = $('.welcomeContent').height();
            var cTop = $('.thirdContainer').height();

            if ($(this).scrollTop() >= (parseInt(aTop) - 200)) {
                $('.welcomeContent').addClass('fadeInRight1');
            }
            if ($(this).scrollTop() >= aTop + bTop + 160) {
                $('.connectionUserContainer .connectionUserIcon').addClass('fadeInUp');
            }
            if ($(this).scrollTop() >= aTop + bTop + cTop + bTop - 50) {
                $('.contactImage').addClass('fadeInLeft');
            }
            if ($(this).scrollTop() >= aTop + bTop + cTop + bTop + 550) {
                $('.contactContent').addClass('fadeInUp');
            }
        });
    });
</script>
<style> 
    .carousel-item{
        transition: transform 1s ease-in-out,-webkit-transform 1s ease-in-out!important;
    }
    .fadeInUp{
        position: relative;
        -webkit-animation-duration: 2s;  /* Safari 4.0 - 8.0 */      
        animation-duration: 2s;  
    } 
    .fadeInLeft{
        position: relative;
        -webkit-animation-duration: 2s;  /* Safari 4.0 - 8.0 */      
        animation-duration: 2s;  
    } 

    .fadeInRight1{
        position: relative;
        -webkit-animation-name: example;  /* Safari 4.0 - 8.0 */
        -webkit-animation-duration: 3s;  /* Safari 4.0 - 8.0 */  
        animation-name: example;
        animation-duration: 2s;  
    }   

    @-webkit-keyframes example {
        from {
            opacity: 0;
            -webkit-transform: translate3d(40%, 0, 0);
            transform: translate3d(40%, 0, 0);
        }
        to {
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }
    }
    @keyframes example {
        from {
            opacity: 0;
            -webkit-transform: translate3d(40%, 0, 0);
            transform: translate3d(40%, 0, 0);
        }
        to {
            opacity: 1;
            -webkit-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
        }
    }   

</style>
@endpush
