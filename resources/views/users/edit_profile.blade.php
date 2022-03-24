@extends('layouts.elements.app')
@section('content')
<section class=" my-md-5 my-3 contact-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 mb-3 d-flex">
                <a href="{{route('users.my-profile')}}" class="backToProfile small">
                    <i class="fas fa-long-arrow-alt-left pr-1"></i>back to my profile
                </a>
                @if(isset($userData->userProfile['updated_at']) && $userData->userProfile['updated_at'] != '')
                @php  $date = $userData->userProfile['updated_at']->setTimezone('EST'); @endphp
                <h6 class="ml-auto mt-2  d-md-none small" style="color:#000000">Last Updated:<br><span class="text-success">{{date('m/d/Y',strtotime($date)).' at '.date('h:iA',strtotime($date)).' EST'}}</span></h6>
                @endif
            </div>
            <div class="col-sm-7 offset-md-0 offset-3 mb-md-4 d-flex">
                <h2 class="textChange">Edit Profile</h2>
                @if(isset($userData->userProfile['updated_at']) && $userData->userProfile['updated_at'] != '')
                @php  $date = $userData->userProfile['updated_at']->setTimezone('EST'); @endphp
                <h6 class="ml-auto mt-2 d-none d-md-block" style="color:#000000">Last Updated:<br><span class="text-success small">{{date('m/d/Y',strtotime($date)).' at '.date('h:iA',strtotime($date)).' EST'}}</span></h6>
                @endif
            </div>
        </div>
        <div class="row  order-md-last bg-white shadow-sm rounded-lg">
            <div class="col-sm-5 mt-md-5">
                <div class="text-center profileImg mt-3">
                    <img  class="currentImage proImg "  src="{{($userData['profile_pic'])?$userData['profile_pic']:'https://cdn2.iconfinder.com/data/icons/website-icons/512/User_Avatar-512.png'}}" alt=""/>
                    <img id="" class="upload-demo changedImage proImg  d-none"  src="" alt=""/>
                    <br class="m-0">
                    <div class="file btn btn-sm changeImage">
                        Change Photo
                        <input type="file" name="profile_pic" class="profilePic" id="upload">
                        <input type="hidden" name="user_id" class="userId" value="{{$userData['id']}}" style="">
                    </div>
                </div>
                <div class="text-center cropImageButton  d-none ">
                    <button class="btn btn-success upload-result" style="width:80%;border-radius:0px;padding: 2px;">Crop Image</button>
                </div>
            </div>
            <div class="col-sm-7">
                <form action="{{route('updateUserProfile')}}" method="post" class="px-2 py-4 contact-form">
                    @csrf
                    <input type="hidden" name="user_id"  value="{{$userData['id']}}" style="">
                    <div class="form-group">
                        <label for="fullname">Fullname</label>
                        <input type="text" class="form-control"  autocomplete="off" name="fullname" value="{{$userData['fullname']}}">
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" autocomplete="off" name="email" value="{{$userData['email']}}">
                        </div>
                        <div class="col-md-6">
                            <label for="contact">Phone Number</label>
                            <input type="text" class="form-control company-contact-input" autocomplete="off" name="contact" value="{{isset($userData['mobile_number'])?$userData['mobile_number']:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" autocomplete="off" name="address" value="{{isset($userData->userProfile['location_address1'])?$userData->userProfile['location_address1']:''}}">
                    </div>
                    <div class="form-group">
                        <label for="state">Country</label>
                        <input type="text" class="form-control" autocomplete="off" name="country" value="{{isset($userData->userProfile->location_country)?$userData->userProfile->location_country:''}}">
                    </div>
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" class="form-control" autocomplete="off" name="state" value="{{isset($userData->userProfile->location_state)?$userData->userProfile->location_state:''}}">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control " autocomplete="off" name="city" value="{{isset($userData->userProfile->location_city)?$userData->userProfile->location_city:''}}">
                    </div>
                    <div class="form-group">
                        <label for="zipcode">Zipcode</label>
                        <input type="text" class="form-control" autocomplete="off" name="zipcode" value="{{isset($userData->userProfile->location_zipcode)?$userData->userProfile->location_zipcode:''}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">About me</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="7" style="font-size: 14px;">{{isset($userData['description'])?$userData['description']:''}}</textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <input type="submit" value="Update" class="btn btn-success py-2 w-50">
                    </div>
                </form>
                <div class="text-center">
                    <a href="javascript:void();"></a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $uploadCrop = $('.upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 190,
            height: 190,
            type: 'square'
        },
        boundary: {
            width: 200,
            height: 200
        }
    });

    $('#upload').on('change', function () {
        $('.currentImage').addClass('d-none');
        $('.croppie-container').show();
        $('.changeImage').addClass('d-none');
        $('.cropImageButton').removeClass('d-none');
        $('.cropImageButton').removeClass('d-none');
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
                console.log('jQuery bind complete');

            });
        }
        reader.readAsDataURL(this.files[0]);
    });


    $('.upload-result').on('click', function (ev) {
        var user_id = $('.userId').val();
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                url: "/updateUserPic",
                type: "POST",
                data: {"image": resp},
                success: function (data) {
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        });
    });


</script>
<style>
    input{
        font-size:14px!important;
    }
    label{
        color:#00ab2c;
        margin-bottom: 0px;
        font-size: 14px;
    }
    .croppie-container{
        display:none;
    }
    h5 a{
        font-size: 15px;
    }
    .proImg{
        width: 150px;
        height: 150px;
        border-radius: 50%;
    }
    .profileImg .file{
        background: #00ab2c;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: -2%;
        width: 50%;
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
    .backToProfile{
        /*text-decoration:underline;*/
        color: #0072bc
    }

    @media (max-width: 500px) {
        .profileImg .file {
            width: 60%!important;
            margin-bottom: 2rem;
        }
        .textChange{
            font-size: 22px;
            font-weight:600;
            margin-left: 20px;
        }
        .backToProfile{
            font-size: 12px;
        }
        .cr-boundary{
            width: 100%!important;
        }
    }
    @media (min-width: 600px) {
        .cr-boundary{
            width: 400px!important;
        }
    }
</style>
@endpush
