@extends('layouts.elements.app')
@section('content')
<section class=" my-md-5 my-3 contact-section bg-light">
    <div class="container">
        <div class="row d-flex mb-2 contact-info">
            <div class="col-sm-5 mb-3 d-flex">
                <a href="{{route('users.business-profile')}}" class="backToProfile small">
                    <i class="fas fa-long-arrow-alt-left pr-1"></i>back to business profile
                </a> 
                @if(isset($data['updated_at']) && $data['updated_at'] != '')
                @php  $date =$data['updated_at']->setTimezone('EST'); @endphp
                <h6 class="ml-auto mt-2  d-none small" style="color:#000000">Last Updated:<br><span class="text-success">{{date('m/d/Y',strtotime($date)).' at '.date('h:iA',strtotime($date)).' EST'}}</span></h6>
                @endif
            </div>
            <div class="col-md-7 mb-md-4 d-flex forMobile">
                <h2 class="h3">Edit Business Profile</h2>
                @if(isset($data['updated_at']) && $data['updated_at'] != '')
                @php  $date = $data['updated_at']->setTimezone('EST');  @endphp
                <h6 class="ml-auto mt-2 d-none d-md-block small" style="color:#000000">Last Updated:<br><span class="text-success">{{date('m/d/Y',strtotime($date)).' at '.date('h:iA',strtotime($date)).' EST'}}</span></h6>
                @endif
            </div>                    
        </div>
        <div class="row">
            <div class="col-md-6 order-md-last bg-white shadow-sm  mx-auto" >  
                @if (session()->has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> Succesfully Updated
                </div>
                @endif              
                <form action="{{route('updateBusiness')}}" method="post" class="contact-form p-3">
                    @csrf
                    <div class="form-group">
                        <label class="mb-0">Business Name</label>
                        <input type="text" class="form-control" name="business_name" value="{{isset($data->userBusiness['business_name']) ? $data->userBusiness['business_name'] :''}}">
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Business Address</label>
                        <input type="text" class="form-control" name="business_address" value="{{isset($data->userBusiness['address']) ? $data->userBusiness['address'] : ''}}">
                    </div>                    
                    <div class="form-group text-center">
                        <input type="submit" value="Update" class="btn btn-success w-50 py-2 mt-2">
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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
            url: '/updateUserPic',
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

    $(document).on('focus', 'input', function () {
        $('.alert').hide();
    });
</script>
<style>
    label{
        color:#ff7c00!important;
            margin-bottom: 0px;
        font-size: 14px;
    }
    input{
        font-size:14px!important;
    }
    #proImg{
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
        width: 30%;
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
        .forMobile{
            justify-content: center;
        }
        .forMobile .h3{
            font-size:20px;
            text-align: center;
        }

    }
</style>
@endpush