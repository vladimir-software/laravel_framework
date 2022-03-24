@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="container-fluid grid-margin">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard Top</h4>
                    <form class="forms-sample" method="post" action="{{route('admin.bootstrap.storeAd')}}" enctype="multipart/form-data">  
                        @csrf
                        <div class="text-center profileImg mb-4">
                            <div class="spinner d-none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>            
                            @if(!empty($adTop))
                                <div class="text-center" style="background: #8a888878">
                                    <a href="{{$adTop->url}}" target="_blank">
                                        <img src="/{{$adTop->image}}" width="728px" height="90px">
                                    </a>
                                </div>
                            @endif
                            <br class="m-0">
                            <div class="file btn btn-sm">
                                Select File    
                                <input type="file" name="image" class="profilePic" onchange="positionTop(this);" required="true">
                            </div> <br/>
                             <i>Top Leaderboard (728x90)</i>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Destination URL</label>
                            <input type="text" name="url" placeholder="https://" value="{{(isset($adTop->url))?$adTop->url:''}}" class="form-control input-sm" required="true">
                            <input type="hidden" name="position" value="1">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success w-100">Upload</button>    
                        </div>                      
                    </form>
                    <form class="forms-sample" method="post" action="{{route('admin.bootstrap.removeAd')}}">  
                        <br/>@csrf
                        <input type="hidden" name="ad_position" value="1">
                        <button type="submit" class="btn btn-danger pull-right">Remove Ad</button>
                    </form>                
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Dashboard Bottom</h4>  
                    <form class="forms-sample" method="post" action="{{route('admin.bootstrap.storeAd')}}" enctype="multipart/form-data">  
                        @csrf
                        <div class="text-center profileImg mb-4">
                            <div class="spinner d-none">
                                <div class="rect1"></div>
                                <div class="rect2"></div>
                                <div class="rect3"></div>
                                <div class="rect4"></div>
                                <div class="rect5"></div>
                            </div>
                            @if(!empty($adBottom))
                                <div class="text-center" style="background: #8a888878">
                                    <a href="{{$adBottom->url}}" target="_blank">
                                        <img src="/{{$adBottom->image}}" width="728px" height="90px">
                                    </a>
                                </div>
                            @endif
                            <br class="m-0">
                            <div class="file btn btn-sm">
                                Select File    
                                <input type="file" name="image"  class="profilePic" onchange="positionBottom(this)" required="true"> 
                            </div> <br/>
                            <i>Bottom Leaderboard (728x90)</i>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Destination URL</label>
                            <input type="text" name="url" value="{{(isset($adBottom->url))?$adBottom->url:''}}" placeholder="https://"  class="form-control input-sm" required="true">
                            <input type="hidden" name="position" value="2">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-success w-100">Upload</button>
                        </div>
                    </form>
                    <form class="forms-sample" method="post" action="{{route('admin.bootstrap.removeAd')}}">  
                        <br/>@csrf
                        <input type="hidden" name="ad_position" value="2">
                        <button type="submit" class="btn btn-danger pull-right">Remove Ad</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function positionTop(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('topImage').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function positionBottom(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                document.getElementById('bottomImage').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<style>
    .proImg{
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }
    .profileImg .file{
        background: #0072bc;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: -2%;
        width: 45%;
        border: none;
        border-radius: 0;
        font-size: 15px;
    }
    .profileImg .file .profilePic{
        position: absolute;
        position: absolute;
        opacity: 0;
        right: -76px;
        top: 6px;
    }
    .spinner {
        width: 50px;
        height: 40px;
        text-align: center;
        font-size: 10px;
        position: absolute;
        left: 43%;
        top: 32%;
    }

    .spinner > div {
        background-color: #0072bc;
        height: 100%;
        width: 6px;
        display: inline-block;

        -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
        animation: sk-stretchdelay 1.2s infinite ease-in-out;
    }

    .spinner .rect2 {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .spinner .rect3 {
        -webkit-animation-delay: -1.0s;
        animation-delay: -1.0s;
    }

    .spinner .rect4 {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .spinner .rect5 {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    @-webkit-keyframes sk-stretchdelay {
        0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
        20% { -webkit-transform: scaleY(1.0) }
    }

    @keyframes sk-stretchdelay {
        0%, 40%, 100% { 
            transform: scaleY(0.4);
            -webkit-transform: scaleY(0.4);
        }  20% { 
            transform: scaleY(1.0);
            -webkit-transform: scaleY(1.0);
        }
    }
    @media (max-width: 700px) { 
        .profileImg .file {           
            width: 60%!important;
            margin-bottom: 2rem;

        }
        .spinner{
            left: 43%;
        }

    }
</style>
@endpush
