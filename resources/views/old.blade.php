@extends('layouts.app')
@section('content')
<div class="hero-wrap">
    <div class="overlay"></div>
    <div class="container position-relative">   
        <div  class="indexLogo text-center d-none d-md-block">
            <img src="{{asset('asset/connect_eo_new.png')}}" style="width: 250px;">
        </div>
        <div  class="text-center d-md-none">
            <img src="{{asset('asset/logo_mobile.png')}}" class="m-4" style="width: 100px;" height="auto">
        </div>
        <div class="col-12 col-sm-10 col-md-9 col-xl-8  rounded p-4 mt-md-4  mx-auto contentContainer mb-0" style="">
            <div>
                <p>Welcome to ConnectEO, a platform providing a safe space for entrepreneurs to collaborate with like-minded creators to expand their businesses, help others with their businesses and build meaningful, revenue-generating relationships. </p>
                <p>Register now for our Beta launch prior to December 31st and receive a free premium subscription for 12 months (a $540 value)!</p>
                <p>Happy Connecting!</p>
                <div class="text-center mt-4">
                    <a href="{{route('signup')}}" class="btn btn-success px-5 py-3 startConnecting">Start Connecting</a>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center footer-2 ">©2019 ConnectEO Network, LLC. All Rights Reserved.</div>
</div>
@endsection
@push('styles')
<style> 
    body {
        background-image: url('asset/bg-index.jpeg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;
    }
    .contentContainer{
        background: #ffffff9e;
    }
    .indexLogo{
        padding-top: 50px;
    }
    .contentContainer p{
        color: #000!important;
    }
    .slider-text p{
        font-size: 16px!important;
        letter-spacing: .5px;
        text-shadow: 0px 1px 1px #000; 
    }
    .footer-content{
        font-size:15px;
        width: 100%;
        color:#000;
    }
    .startConnecting{
        font-size:17px!important;
        letter-spacing: .5px;
        font-weight:bold;
    }
    .startConnecting:focus{
        color:#fff!important;
    }
    .footer-2 {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: #000000;
        text-align: center;
    }

    @media screen and (max-height:640px){
        .footer-2 {
            margin-top: 2rem;
            position: relative;
        }
    }
    @media screen and (max-width:1000px){
        .footer-2 {
            padding-top: .5rem;
            font-size:14px;
        }
        .indexLogo{
            padding-top: 25px;
        }

    }
    @media screen and (max-width:900px){ 
        .indexLogo{padding-bottom: 15px;}
        p{font-size: 15px;}
    }   

</style>
@endpush