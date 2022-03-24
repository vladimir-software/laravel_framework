@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-md-12 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit User</h4> 
                    <div class="text-center profileImg">
                        <div class="spinner d-none">
                            <div class="rect1"></div>
                            <div class="rect2"></div>
                            <div class="rect3"></div>
                            <div class="rect4"></div>
                            <div class="rect5"></div>
                        </div>
                        @if(!empty($users['profile_pic']))                            
                        <img id="proImg" src="{{asset($users['profile_pic'])}}" alt="" width="150px" height="150px;">
                        @else
                        <img id="proImg" src="{{asset('asset/noimage_person.png')}}" alt=".." width="150px" height="150px;">
                        @endif
                        <br class="m-0">
                        <div class="file btn btn-sm">
                            Change Photo
                            <input type="file" name="profile_pic" class="profilePic" style="">
                            <input type="hidden" name="user_id" class="userId" value="{{$users['id']}}" style="">
                        </div> 
                    </div>
                    <form class="forms-sample" method="post" action="{{route('users.update-user1')}}">  
                        @csrf
                        <input type="hidden" value="{{$users['token']}}" name="user-id">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Full Name</label>
                            <input type="text" name="fullname" value="{{$users['fullname']}}" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Email Address</label>
                            <input type="text" name="email"  value="{{$users['email']}}" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="contact">Mobile Number</label>
                            <input type="text" name="contact" value="{{$users['mobile_number']}}" class="form-control input-sm company-contact-input">
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Submit</button>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>

    $(document).on("change", ".profilePic", function () {
        $(".spinner").removeClass('d-none');
        var file_data = $(this).prop("files")[0];
        var user_id = $('.userId').val();
        var myFormData = new FormData();
        myFormData.append('profile_pic', file_data);
        myFormData.append('user_id', user_id);
        var myFile = $(this).prop('files');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/updateProfilePic',
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            dataType: 'json',
            data: myFormData,
            success: function (data)
            {
                if (data.status == 'success') {
                    $('#proImg').attr('src', data.user.profile_pic);
                    $(".spinner").addClass('d-none');
                } else {

                }
                ;
            }
        });
    });
</script>
<style>
/*    #proImg{
        width: 150px;
        height: 150px;
    }*/
    .profileImg .file{
        background: #0072bc;
        color: #fff;
        position: relative;
        overflow: hidden;
        margin-top: -2%;
        width: 18%;
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
        left: 48%;
        top: 25%;
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