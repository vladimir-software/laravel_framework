@extends('layouts.elements.app')
@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-sm-12 col-md-7 col-lg-8 mb-4 mb-md-0 order-2 order-md-12">
            <div class="card mb-md-0">
                <div class="card-header text-center  font-bold" style="border-bottom:0px;">
                    @if(Auth::user()->profile_pic == "")
                    <h5 style="color: #ff7c00;font-family: sans-serif;"><i class="fas fa-user-circle"></i> My Profile</h5>
                    @else
                    <h5 style="color: #ff7c00;font-family: sans-serif;"><i class="fas fa-user-circle"></i> My Profile</h5>
                    @endif
                </div>
                <div class="card-body row centerContent text-center">
                    <div class="col-sm-12 col-md-3 col-lg-2 text-center mb- md-4 mb-2" onclick="window.location.href = '/my-profile'" style="cursor:pointer;">
                        <img class="rounded-circle img-center img-fluid shadow shadow-lg--hover" src="{{isset(Auth::user()->profile_pic)?asset(Auth::user()->profile_pic):asset('asset/noimage_person.png')}}" alt="" width="100%" height="auto">
                        <img class="upload-demo changedImage proImg  d-none"  src="" alt=""/>
                        <input type="file" name="profile_pic" class="profilePic" id="upload" hidden="">
                        <div class="text-center" style="margin-top: -18px;position: relative;left: 37px;">
                            <span class="imgEditIcon">
                                <i class="fas fa-camera text-dark iconForCamera" style="font-size: 12px;"></i>
                            </span>
                        </div> 
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-5 mb-4 px-1">                      
                        @if(!empty(Auth::user()->company_name))
                            <h4 class="text-capitalize mb-0 userName" style="font-size:18px;">{{Auth::user()->company_name}} <span class="editCompanyName  small"><a href="javascript:void(0)" class="openCompanyNameModal text-lowercase small"><u>edit</u></a></span></h4>
                        @else
                            <h4 class="text-capitalize mb-0 userName" style="font-size:18px;">Company Name <span class="editCompanyName small"><a href="javascript:void(0)" class="openCompanyNameModal text-lowercase small"><u>edit</u></a></span></h4>
                        @endif
                        @php $user = auth()->user();@endphp                        
                        <p class="m-0 p-0 small text-dark userLocation"><i class="fas fa-map-marker-alt"></i> {{isset($user->userProfile->location_address1)?$user->userProfile->location_address1:"Not Available" }}</p>
                    </div>
                    <div class="col-sm-12 col-md-5 col-lg-5 mb-4">
                        <div class="">
                            <h5><i class="fas fa-user-friends connectionIcons"></i> 
                                <a href="{{route('user.connect-leads')}}" class="subHeading text-dark">My Connections
                                    @if($connection!=0)(<span class="myConnectionCount">{{$connection}}</span>)
                                    @else
                                        <span class="connectionCount d-none">(<span class="myConnectionCount">{{$connection}}</span>)</span>
                                    @endif
                                </a>
                            </h5> 
                            <h5 ><i class="far fa-star connectionIcons"></i> <span class="subHeading">Recommendations</span><span style="font-size: 13px;visibility:hidden">(10)</span></h5> 
                        </div>
                    </div>                    
                </div>
                <div class="border-top">
                    <div  class="p-3 row homeBtn">
                        <div class="col-sm-4">
                            <a href="{{route('users.my-profile')}}" class="btn editUser w-100 mb-2 " ><i class="fas fa-edit"></i> Edit Profile</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{route('users.business-profile')}}" class="btn share  w-100" ><i class="fas fa-briefcase"></i> Business Settings</a>
                        </div>
                        @if(Auth::user()->subscription_type == 3)
                            <div class="col-sm-4">
                                <a href="{{route('manage-promo')}}" class="btn w-100" style="border: 1px solid #000!important;color: #000!important;">Manage Promo</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-5 col-lg-4 order-1 order-md-12 mb-5">
            <div class="card p-0 m-0 shadow" style="border:none;">
                <div class="text-center">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                </div>
                <div class="card-header text-center font-bold position-relative " style="border-bottom:0px;">
                    <div class="text-center">
                        <h5 style="color: #ff7c00; font-family: sans-serif;"> <i class="fas fa-user-friends"></i> My Matches</h5>
                    </div> 
                    <a href="javascript:void(0);" class="questionModal ml-auto"><i class="far fa-question-circle"></i></a>
                </div>
                <div class="card-body p-0 centerContent">              
                    @include('swipe')
                </div>
                <!--overlayContainer-->
            </div>
        </div>
    </div> 
</div>
@if(!empty($adBottom))  
@foreach($adBottom as $bb)
    <div class="text-center mb-1" >
        <a href="{{$bb->url}}" target="_blank">
            <img src="{{$bb->image}}" width="728px" height="90px">
        </a>
    </div>
@endforeach
@endif
<!-- START MODAL -->
<div class="modal fade" id="editCompanyNameModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header">
                <div class="ml-auto">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> 
                <form action="{{route('updateCompanyName')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="exampleFormControlInput1" class="text-left mb-0" style="color:#000">Company Name</label>
                        <input type="text" class="form-control" value="{{(Auth::user()->company_name != '')?Auth::user()->company_name:''}}" name="company_name" id="exampleFormControlInput1" required="" placeholder="">
                    </div>
                    <button type="submit" class="btn-sm btn btn-success my-3 py-1 w-100">Update</button>
                </form>
            </div>          
        </div>
    </div>
</div>
<!--END MODAL-->
<!-- START MODAL -->
<div class="modal fade" id="questionModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header">
                <div class="ml-auto">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">     
                <p class="text-dark small setSliderText"></p>              
            </div>
        </div>
    </div>
</div>
<!--END MODAL-->
<!-- START MODAL -->
<div class="modal fade" id="profileChangeAlertModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header">
                <div class="ml-auto">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">              
                <div>
                    <div class="py-4">
                        <p class="text-bold text-dark">You are not currently visible on ConnectEO because you have not updated a profile photo.  Update your profile photo to be seen!</p>
                        <a href="javascript:void(0);" class="btn-sm btn btn-success px-4 py-1" data-dismiss="modal">Got it, thanks.</a>
                    </div>
                </div>      
            </div>         
        </div>
    </div>
</div>
<!--END MODAL-->
<!-- START CONNECTED MODAL -->
<div class="modal fade" id="connectedModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header">
                <div class="ml-auto">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">     
                <img id="fromUserConnectedImg" class="currentImage" src="/asset/noimage_person.png" style="max-width: 50px"/>
                <img id="toUserConnectedImg" class="currentImage" src="/asset/noimage_person.png" style="max-width: 50px"/> 
                <h5 class="m-0 text-capitalize text-dark">Connected!</h5>
                <p class="text-dark small setSliderText">You are now connected with <strong><span id='connectedWithName'></span></strong></p>
                <a id="toUserConnectedProfile" type="button" href="" class="btn btn-success" style="color:white;">
                    View Profile
                </a>
                <button data-dismiss="modal" aria-label="Close" class="btn">
                    close
                </button>
            </div>
        </div>
    </div>
</div>
<!--END CONNECTED MODAL-->
@endsection
@push('scripts')
<style>
    .questionModal{
        top: 15px;
        right: 10px;
        position: absolute;
        color: #000;
    }
    .progress-bg{
        background: #fff;
        width: 100%;
        height:20px;
        border-top-right-radius: 9px;
        border-bottom-right-radius: 9px;
    }
    #filledProfile li{
        display: flex;
        justify-content: center;
        align-items: center;
    }
    #filledProfile h5{
        font-size: 18px;
    }
    .iconBackground{
        background: #ff7c00;
        border-radius: 50%;
        padding: 5px 10px;
        margin-left: auto;
    }
    #filledProfile p{
        font-size:14px;
    }
    .profile-bg{
        background-color: #abe9cd;
        background-image: linear-gradient(315deg, #abe9cd 0%, #3eadcf 74%);
    }
    .btn-website{
        background: #5cb95c;
        color: #fff;
    }
    .card{
        box-shadow: none!important;
        border-radius:10px;
    }
    body {
        background-image: url('asset/home.png');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;
    }
    .centerContent{
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 999!important;
    }
    .homeBtn a{
        font-size: 16px;
        padding: 10px;
        font-weight: 600;
        letter-spacing: .2px;
    }
    .currentImage{
        width: 100%;
        border-radius: 5px;
    }
    .userName{
        font-weight: 600!important;
    }    
    .imgEditIcon {
        border: 2px solid #fff;
        border-radius: 50%;
        text-align: center;
        background: #e1e6e5;
        padding: 1px 6px;
    }
    .myConnectionCount{
        color: #ff7c01;
    }
    .subHeading{
        font-size: 13px;
        position: relative;
        bottom: 2px;
        font-family: Verdana;
    }  
    .user-profile img{
        width: 100%;
        height: 100%
    }
    h5{
        margin-bottom: 0px!important;
    }

    .croppie-container{
        display:none;
    }
    .editUser{
        background: #ff7c00!important;
        color:#fff;
    }
    .editUser:hover{
        color:#fff!important;
    } 
    .share{
        border: 1px solid #ff7c00!important;
        color: #ff7c00!important;
    }
    .share:hover{
        background: none!important;
    }
    @media screen and (max-width: 720px) {
        .currentImage{
            width: 150px;
            border-radius: 5px;
        }
        .userName{
            text-align: center;
            font-weight: 400!important;
            font-size: 16px;
            color: #000000;
        }
        .userLocation{
            text-align: center;
            font-size: 11px!important
        }
        .connectionIcons{
            font-size: 18px;
        }
    }
    @media screen and (max-width: 60em) {
        .actionButtons .editUser,.share{
            width: 100%!important;
        }  
        .actionButtons .share{
            margin-top: 1rem!important;
        }  
    }
</style>
<script>
    $(document).on('click', '.openCompanyNameModal', function () {
        $('#editCompanyNameModal').modal('show');
    });

<?php if (Auth::user()->profile_pic == "") { ?>
        $(document).ready(function () {
            var check = localStorage.getItem("profilePic");
            if (check == null) {
                $('#profileChangeAlertModal').modal('show');
                localStorage.setItem("profilePic", "empty");
            }
        });
<?php } ?>

</script>

<script type="text/javascript">

    $(document).on('click', '.questionModal', function () {
        if ($('*').hasClass('noAvailableUsers')) {
            $('.setSliderText').text('We are currently searching for more opportunities for your business to grow. Please check again later.')
        } else {
            $('.setSliderText').text('These matches are being shown based on our matching algorithm.')
        }
        $('#questionModal').modal('show');
    });

    $(document).on("change", "#upload", function () {
        var file_data = $(this).prop("files")[0];
        var myFormData = new FormData();
        myFormData.append('profile_pic', file_data);
        var myFile = $(this).prop('files');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/changeProfilePic',
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            dataType: 'json',
            data: myFormData,
            success: function (data)
            {
                if (data.status == 'success') {
                    location.reload();
                }
            }
        });
    });
</script>
@endpush
