@extends('layouts.elements.app')
@section('content')
<section class="">
    <div class="container-fluid my-4">     
        <div class="row destacados">     
            <div class="col-sm-4">
                <div style="text-align:center" class="connectionUserIcon">
                    <a href="{{route('connection.collaboration_matches')}}" class="findProductsServices">
                        <img src="{{asset('connection/1_myconnections.png')}}">
                    </a>
                    @if($userConnectForCollboration > 0)
                    <div style="position:relative;top: -21px;" class="row">
                        <div class="col-5 offset-4 pr-0">
                            <p class="imgEditIcon ml-auto">
                                <span style="color:#ff7c00 !important">{{$userConnectForCollboration}}</span>
                            </p>
                        </div>
                    </div>                    
                    @endif                   
                </div>
            </div>
            <div class="col-sm-4">
                <div style="text-align:center" class="connectionUserIcon">
                    <a href="{{route('connection.find_products_services')}}" class="findProductsServices">
                        <img src="{{asset('connection/2_myconnections.png')}}">
                    </a>
                    @if($userConnectForObtain > 0)
                    <div style="position:relative;top: -21px;" class="row">
                        <div class="col-5 offset-4 pr-0">
                            <p class="imgEditIcon ml-auto">
                                <span style="color:#ff7c00 !important">{{$userConnectForObtain}}</span>
                            </p>
                        </div>
                    </div>                   
                    @endif 
                </div>
            </div>
            <div class="col-sm-4">
                <div class="qode-sbl-post-text">
                    <div style="text-align:center" class="connectionUserIcon">
                        <a href="{{route('connection.provide_services_products')}}" class="findProductsServices">
                            <img src="{{asset('connection/3_myconnections.png')}}">
                        </a>   
                        @if($userConnectForProvide > 0)
                        <div style="position:relative;top: -21px;" class="row">
                            <div class="col-5 offset-4 pr-0">
                                <p class="imgEditIcon ml-auto">
                                    <span style="color:#ff7c00 !important">{{$userConnectForProvide}}</span>
                                </p>
                            </div>
                        </div>
                        @endif 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    html, body{
        width:100%;
        height:100%;        
    }
    body {
        background-image: url('asset/connecteo_connections_bg.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;      
    } 
    .destacados{
        padding: 20px 0;
        text-align: center;
        background: #00000029;
    }

    .borderRadius{
        color: #ff7c00!important;
        font-weight: 600;
    }
    .connectionUserIcon img{
        width: 200px;
        height: 200px;
    }
    .connectionUserIcon i {
        font-size: 75px;
        /*color: #fff;*/
    }
    .connectionUserIcon{
        /*background: #fff;*/
        padding: 2rem;
        height: 250px;
        margin-bottom: 1rem
    }
    .connectionUserIcon .collaborationMatches{
        font-size: 20px;
        color:#ff7c00;
    }
    .connectionUserIcon .findProductsServices{
        font-size: 20px;
        color:#157efb;
    }
    .connectionUserIcon .provideProductService{
        font-size: 20px;
        color:#fff;
    }
    .bg-badge{
        background: #6c757d;;
    }  
    .connectionDetailsCard .job-post-item{
        border-radius: 8px;
        margin-bottom: 1.3rem;
    }
    .imgEditIcon {
        border: 2px solid #fff;
        border-radius: 50%;
        text-align: center;
        background: #e1e6e5;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 23px;
        width: 23px;
    }
    .imgEditIcon span{
        font-size: 12px;
    }
    @media screen and (min-width:1000px){
        section{
            display: flex;
            justify-content: center;
            align-items: center;
            height: 89vh;
            width: 100%;
        }
        .destacados{
            padding: 40px 0!important;
        }
    }
    @media screen and (max-width:1000px){
        .connectionUserIcon{
            padding: 0px;
            margin-bottom: 5rem!important;
            height: auto!important;
        }
    }
</style>
@endpush