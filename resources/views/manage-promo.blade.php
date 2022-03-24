@extends('layouts.elements.app')
@section('content')
<div class="container businesProfileContainer bg-white my-4">          
    <div class="row">
        <div class="col-sm-7 mx-auto">
            <div class="card shadow-none border-0">
                <div class="card-body">
                    <h3 class=" main-heading mb-4 text-center">Manage Promo</h3>
                    <div class="text-center">                        
                        <div class="card-profile-image">                        
                            <div class="text-center profileImg">                                 
                                <img onclick=" $('#upload').trigger('click');"  class="currentImage"  src="{{(isset($get->image) && $get->image != '')?asset($get->image):asset('/promo/mange_promo.jpg')}}"  style="width: 350px!important;height: 350px!important;transition:none!important;" alt="image"/>
                                <img id="" class="upload-promo changedImage proImg d-none"  src="" alt=""/>
                                <input type="file" name="profile_pic" class="profilePic" id="upload" hidden="">
                            </div>                            
                            <div class="text-center cropImageButton d-none">
                                <a href="javascript:void(0);" class="btn btn-success upload-result w-50 removeBorder">Save</a>
                                <a href="javascript:void(0);" class="btn btn-primary w-50 mt-2 removeBorder" onclick="location.reload()">Cancel</a>
                            </div>                            
                        </div>                      
                    </div> 
                    <div class="text-center mb-1">      
                        @if(isset($get->image) && $get->image != "")
                        <a href="javascript:void(0);" class="btn btn-primary py-1 mt-1 px-5 changeImage removeBorder" onclick=" $('#upload').trigger('click');">Upload</a>
                        <a href="{{route('removePromoImage')}}" class="btn btn-danger py-1 mt-1 px-5 changeImage removeBorder">Remove</a>
                        @else
                        <a href="javascript:void(0);" class="btn btn-primary  mt-2 w-50 changeImage removeBorder" onclick=" $('#upload').trigger('click');">Upload</a>
                        @endif
                    </div>
                    @if(isset($get->status) && $get->status == 0 && $get->image != "")
                    <div class="text-center mb-3">                      
                        <a href="{{route('sendForApprovalPromo')}}" class="btn btn-success w-50 changeImage removeBorder">Send for Approval</a>
                    </div>
                    @elseif(isset($get->status) && $get->status == 1 && $get->image != "")
                    <div class="text-center mb-3">                      
                        <a href="javascript:void(0);" class="btn btn-success py-1 mt-2  w-50 changeImage removeBorder">Pending Approval</a>
                    </div>
                    @elseif(isset($get->status) && $get->status == 2)
                    <div class="text-center mb-3">                      
                        <a href="javascript:void(0);" class="btn btn-success py-1 mt-2  w-50 changeImage removeBorder">Approved</a>
                    </div>
                    @elseif(isset($get->status) && $get->status == 3)
                    <div class="text-center mb-1">                      
                        <a href="javascript:void(0);" class="btn btn-success py-1 mt-2  w-50 changeImage removeBorder">Rejected</a>
                        @if(isset($get->comment) && $get->comment != "")
                        <p class="text-dark small">({{$get->comment}})</p>
                        @endif
                    </div>                   
                    @endif
                    <form action="{{route('addMangePromoUrl')}}" method="post" class="">
                        @csrf
                        <input type="hidden" name="id" value="{{isset($get->id)?$get->id:''}}">
                        <div class="form-group focused">
                            <label class="form-control-label text-dark mb-1" for="input-username" >URL</label>
                            <input type="text" class="form-control form-control-alternative small" id="input-username" name="url" value="{{isset($get->url)?$get->url:''}}" >
                        </div>    
                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-50 removeBorder py-1">Submit</button>
                        </div>   
                    </form>
                </div>                           
            </div>
        </div>
    </div>          
</div>
@endsection
@push('scripts')
<style>
    .croppie-container {
        display: none;
    }
    .removeBorder{
        border-radius:0px;
        padding: 2px;
    }

</style>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $uploadCrop = $('.upload-promo').croppie({
        enableExif: true,
        viewport: {
            width: 330,
            height: 330,
            type: 'square'
        },
        boundary: {
            width: 350,
            height: 350
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
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                url: "/addPromoImage",
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
@endpush
