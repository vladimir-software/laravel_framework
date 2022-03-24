@extends('layouts.elements.app')
@section('content')
<div class="position-relative profilePages">
    <div style="height:100px;"></div>
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-xl-4 mb-4">
                <div class="card card-profile ">
                    <div class="text-center mb-5">                        
                        <div class="card-profile-image" style="cursor:pointer;">                        
                            <div class="text-center profileImg">                                 
                                <img style="transition:none!important;" onclick=" $('#upload').trigger('click');"  class="currentImage proImg "  src="{{($userData['profile_pic'])?$userData['profile_pic']:asset('asset/noimage_person.png')}}" alt=""/>
                                <img id="" class="upload-demo changedImage proImg  d-none"  src="" alt=""/>
                                <input type="file" name="profile_pic" class="profilePic" id="upload" hidden="">
                            </div>                            
                            <div class="text-center cropImageButton  d-none ">
                                <button class="btn btn-success upload-result" style="width:80%;border-radius:0px;padding: 2px;">Upload Photo</button>
                                <button class="btn btn-primary  mt-2" onclick="location.reload()" style="width:150px;border-radius:0px;padding: 2px;">Cancel</button>
                            </div>
                        </div>                      
                    </div>
                    <div class="text-center" style="margin-top: -15px;position: relative;left:40px; cursor:pointer;">                      
                        <span class="imgEditIcon" onclick=" $('#upload').trigger('click');">                           
                            <i class="fas fa-camera text-dark iconForCamera" style="font-size: 12px;"></i>
                        </span>
                    </div> 
                    <div class="text-center" style="margin-top:-9px;"> <a href="javascript:void(0)" class="small" onclick=" $('#upload').trigger('click');">edit photo</a></div>
                    <div class="card-body  pt-md-4">                        
                        <div class="text-center">
                            <h5 class="text-capitalize ">
                                {{isset($userData['fullname'])?$userData['fullname']:'Unknown'}}<span class="font-weight-light"></span>
                            </h5>
                            <div class=" font-weight-300 userLocation">
                                <i class="fas fa-map-marker-alt"></i>
                                @if(empty($userData->userProfile['location_address1']) && empty($userData->userProfile->location_city) && empty($userData->userProfile->location_state) && empty($userData->userProfile->location_zipcode))
                                Not Available
                                @else
                                {{isset($userData->userProfile['location_address1'])?$userData->userProfile['location_address1']:''}}
                                {{isset($userData->userProfile->location_city)?$userData->userProfile->location_city.', ':' '}}
                                {{isset($userData->userProfile->location_state)?$userData->userProfile->location_state:''}}
                                {{isset($userData->userProfile->location_zipcode)?$userData->userProfile->location_zipcode:''}}
                                @endif
                            </div>
                            <div class="mt-2 userSubscription">
                                <i class="ni business_briefcase-24 mr-2"></i>Current Subscription:  
                                @if(isset($userData['subscription_type']) && $userData['subscription_type'] == 1 || $userData['subscription_type'] == "")
                                <span>Free</span> <a href="{{route('subscription')}}" class="small" style="text-decoration:underline">(Upgrade)</a>
                                @elseif(isset($userData['subscription_type']) && $userData['subscription_type'] == 2)
                                <span>Premium</span> <a href="{{route('subscription')}}" class="small" style="text-decoration:underline">(Upgrade)</a>
                                @else
                                <span>Platinum</span> 
                                @endif
                            </div>
                            <div class="userSubscription">
                                <i class="ni education_hat mr-2"></i>{{$userData['email']}}
                            </div>
                            <hr class="my-4">
                            <p>{{isset($userData['description'])?$userData['description']:''}}</p>
                            <!--<a href="#">Show more</a>-->
                        </div>
                    </div>
                </div>
                <div class="card card-profile mt-4">  
                    <div class="card-body  pt-4 businesProfileContainer"> 


                        @if(isset($business) && $business != '')                       
                        @foreach($business as $products)

                        @if(isset($products['page_name']) && $products['page_name'] == 'page_3')                                   
                        @if(isset($products['answer']) && $products['answer'] != '')
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Primary Goals</h5>   
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="btn  btn-success px-4 editPrimaryGoals" rel="page_3">Edit</a>
                            </div>
                        </div>
                        <div class="d-flex">                                          
                            <ul>
                                @foreach($products['answer'] as $primary)
                                <li  class="nav-link"><i class="fas fa-check-double"></i> {{$primary}}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @endif                       

                        @if(isset($products['page_name']) && $products['page_name'] == 'page_6')
                        @if(isset($products['answer']) && $products['answer'] != '')
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Location</h5> 
                            <div class="ml-auto">
                                <a href="{{route('edit_survey.survey-5')}}" class="btn  btn-success px-4 " style="font-size:13px;" rel="page_6">Edit</a>
                            </div>
                        </div>
                        <div class="d-flex">  
                            <p class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$products['answer']['answer']}} </p>         
                        </div>  
                        @endif
                        @endif

                        @if(isset($products['page_name']) && $products['page_name'] == 'pageForObtainBusiness')
                        @if(isset($products['answer']) && $products['answer'] != '') 
                        @if(isset($is_exist) && $is_exist != '') 
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Obtaining Services</h5>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="px-4 editPrimaryGoals" rel="pageForObtainBusiness"><i class="fas fa-plus customFont"></i> <u>Add more</u></a>
                            </div>
                        </div>
                        <div class="d-flex">   
                            <ul>
                                @foreach($is_exist as $key=> $cat)
                                <li class="nav-link"><i class="fas fa-check-double"></i> 
                                    @if($cat['cat_name'] == "Other" && $products['other'] != "")                                   
                                    {{ $cat['cat_name'] .' ('.$products['other'].')'}}
                                    @else
                                    {{ $cat['cat_name']}}  {{isset($cat['sub_cat_name'])? ' => '.$cat['sub_cat_name']:''}}
                                    @endif      
                                </li>
                                @endforeach
                            </ul>
                        </div>  
                        @endif
                        @else
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Obtaining Services</h5>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="px-4 editPrimaryGoals" rel="pageForObtainBusiness"><i class="fas fa-plus customFont"></i> <u>Add more</u></a>
                            </div>
                        </div> 
                        @endif                      
                        @endif

                        @endforeach

                        @if (!array_key_exists("page_3",$business))
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Primary Goals</h5>   
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="btn  btn-success px-4 editPrimaryGoals" rel="page_3">Edit</a>
                            </div>
                        </div>
                        @endif
                        @if (!array_key_exists("page_6",$business))
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Location</h5> 
                            <div class="ml-auto">
                                <a href="{{route('edit_survey.survey-5')}}" class="btn  btn-success px-4 " style="font-size:13px;" rel="page_6">Edit</a>
                            </div>
                        </div>
                        @endif
                        @if (!array_key_exists("pageForObtainBusiness",$business))
                        <hr>
                        <div class="d-flex ">    
                            <h5 class="sub-heading">Obtaining Services</h5>
                            <div class="ml-auto">
                                <a href="javascript:void(0)" class="px-4 editPrimaryGoals" rel="pageForObtainBusiness"><i class="fas fa-plus customFont"></i> <u>Add more</u></a>
                            </div>
                        </div>
                        @endif
                        @endif                      
                    </div>
                </div>                
            </div>
            <div class="col-xl-8  mb-3">
                <div class="card">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h5 class="mb-0" style="color:#ff7c00!important;">My Profile</h5>
                            </div>
                            <div class="col-4 text-right">
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('updateUserProfile')}}" method="post" class="px-2 py-4 contact-form">
                            @csrf
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-username" >Full Name</label>
                                            <input type="text" id="input-username" name="fullname" value="{{isset($userData['fullname'])?$userData['fullname']:''}}" class="form-control form-control-alternative text-capitalize">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email Address</label>
                                            <input type="email" id="input-email" name="email"  class="form-control form-control-alternative" value="{{$userData['email']}}" placeholder="">
                                            @if (!empty($_REQUEST['msg']))
                                                <div class="alert alert-danger" role="alert">
                                                  Email is already in use by another user.
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <h6 class="heading-small text-muted mb-4">Company information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-company_name" >Company Name</label>
                                            <input type="text" id="input-company_name" name="company_name" value="{{isset($userData['company_name'])?$userData['company_name']:''}}" class="form-control form-control-alternative text-capitalize">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-website_url">Website Url</label>
                                            <input type="text" id="input-website_url" name="website_url"  class="form-control form-control-alternative" value="{{$userData['website_url']}}" placeholder="">
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                            <hr class="my-4">
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Contact information</h6>
                            <div class="pl-lg-4">                                
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-number">Phone Number</label>
                                            <input type="text" name="contact"  id="input-number" class="form-control form-control-alternative company-contact-input" placeholder="" value="{{isset($userData['mobile_number'])?$userData['mobile_number']:''}}">
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-address">Address</label>
                                            <input id="input-address" name="address" class="form-control form-control-alternative"  placeholder="" value="{{isset($userData->userProfile->location_address1)?$userData->userProfile->location_address1:''}}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-city">City</label>
                                            <input type="text" name="city"  id="input-city" class="form-control form-control-alternative" placeholder="" value="{{isset($userData->userProfile->location_city)?$userData->userProfile->location_city:''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-state">State</label>
                                            <input id="input-state" name="state" class="form-control form-control-alternative"  placeholder="" value="{{isset($userData->userProfile->location_state)?$userData->userProfile->location_state:''}}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" name="country"  id="input-country" class="form-control form-control-alternative" placeholder="" value="{{isset($userData->userProfile->location_country)?$userData->userProfile->location_country:''}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Zip Code</label>
                                            <input type="number" name="zipcode"   id="input-postal-code" class="form-control form-control-alternative" placeholder="" value="{{isset($userData->userProfile->location_zipcode)?$userData->userProfile->location_zipcode:''}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Description -->
                            <label class="form-control-label" for="input-about" style="padding-left: 1.5rem;">About me</label>
                            <!--<h6 class="heading-small text-muted" style="padding-left: 1.5rem;color:#525f7f!important;text-transform: capitalize!important;font-s">About me</h6>-->
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                    <textarea rows="7" name="description" class="form-control form-control-alternative" placeholder="" style="font-size:14px;">{{isset($userData['description'])?$userData['description']:''}}</textarea>
                                </div>
                            </div>
                            <div class="pl-lg-12">
                                <div class="form-group focused text-center">                                  
                                    <input type="submit" value="Update" class="btn btn-success py-2 w-50">  </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- START MODAL -->
<div class="modal fade" id="editGoals" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
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
                <div class="appendFormData text-center">

                </div>
            </div>         
        </div>
    </div>
</div>
<!--END MODAL-->
@endsection
@push('scripts')
<style>
    .appendFormData .mainHeading{
        color: #ff7c00!important;
        font-size: 17px!important;
        font-weight:600;
    }
    .customFont{
        font-size: 13px;
    }
    .editPrimaryGoals{
        font-size: 13px;
    }
    .addMoreCategory{
        font-size: 14px;
    }
    #appendCategory th, #appendCategory td{
        color: #000;
        font-size: 13px;
    }
    .suveyLabel{
        color: #333!important;
    }
    .imgEditIcon {
        border: 2px solid #fff;
        border-radius: 50%;
        text-align: center;
        background: #e1e6e5;
        padding: 1px 6px;
    }
</style>
<script type="text/javascript">
    $(document).on('click', '.editPrimaryGoals', function () {
        var surveyId = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "/editPrimaryGoals",
            data: {surveyId: surveyId},
            dataType: 'html',
            success: function (data)
            {
                $('#editGoals').modal('show');
                $('.appendFormData').html(data);
            }
        });
    });

    $(document).on('submit', '#submitEditedPrimaryGoals', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/submitEditedSurvey2",
            data: $("#submitEditedPrimaryGoals").serialize(),
            dataType: 'json',
            success: function (data)
            {
                if (data.status == "success") {
                    toastr["success"](data.message);
                    setTimeout(function () {
                        window.location.href = "/my-profile"
                    }, 800);

                } else {
                    $(".errorForObtainingServices").removeClass("d-none");
                    $(".errorMessage").html(data.message);
                }
            }
        });
    });

    $(document).on('change', ".setSubCategory", function (e) {
        $(".appendErrorForSameServies").html('');
    });

    $(document).on('change', ".getSubCategory", function (e) {
        if ($(".getSubCategory  option:selected").text() == "Other") {
            $('.textForOther').show();
        } else {
            $('.textForOther').hide();
        }
        $(".appendErrorForSameServies").html('');
        var catId = $(this).val();
        var catData = $(".getSubCategory  option:selected").text();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/getSubCategory",
            data: {cat_id: $(this).val()},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.data == '') {
                    $("#appendCategory tr").each(function (key, htm) {
                        var firstTd = $(htm).children('td').eq(0).find('input').val();
                        var secondTd = $(htm).children('td').eq(1).find('input').val();

                        if (catId === firstTd && secondTd === "") {
                            $(".appendErrorForSameServies").html('<small>This category already exists.</small>');
                            $('.textForOther textarea').prop('readonly', true);
                            $(".addSelectCat").prop('disabled', true);
                            return false;
                        } else {
                            $('.textForOther textarea').prop('readonly', false);
                            $(".appendErrorForSameServies").html('');
                            $(".addSelectCat").prop('disabled', false);
                        }
                    });

                    $('.hideSubCat').hide();
                    $('.setSubCategory').html('');
                } else {
                    $('.hideSubCat').show();
                    $('.setSubCategory').html('');
                    $('.setSubCategory').append('<option value="">---Select----</option>');
                    $.each(data.data, function (index, value) {
                        $('.setSubCategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                    $("#appendCategory tr").each(function (key, htm) {
                        var firstTd = $(htm).children('td').eq(0).find('input').val();
                        var secondTd = $(htm).children('td').eq(1).find('input').val();
                        if (catId === firstTd && secondTd === "") {
                            $(".appendErrorForSameServies").html('<small>This category already exists. Please select sub category.</small>');
                            $(".addSelectCat").prop('disabled', true);
                            return false;
                        } else {
                            $(".appendErrorForSameServies").html('');
                            $(".addSelectCat").prop('disabled', false);
                        }
                    });
                }
            }
        });
    });

    $(document).on("change", ".setSubCategory", function () {
        var catIds = $(".setSubCategory  option:selected").val();

        $("#appendCategory tr").each(function (key, htm) {
            var firstTd = $(htm).children('td').eq(0).find('input').val();
            var secondTd = $(htm).children('td').eq(1).find('input').val();
            if ($(".getSubCategory  option:selected").val() == firstTd && secondTd == catIds) {
                $(".appendErrorForSameServies").html('<small>This category and sub category already exists.</small>');
                $(".addSelectCat").prop('disabled', true);
                return false;
            } else {
                $(".appendErrorForSameServies").html('');
                $(".addSelectCat").prop('disabled', false);
            }
        });
    });

    $(document).on('submit', '.submitEditedObtainServices', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/submitEditedSurvey02",
            data: $(".submitEditedObtainServices").serialize(),
            dataType: 'json',
            success: function (data)
            {
                if (data.status == "success") {
                    toastr["success"](data.message);
                    setTimeout(function () {
                        window.location.href = "/my-profile"
                    }, 800);

                } else {
                    $(".errorForObtainServices").removeClass("d-none");
                    $(".errorMessageForObtainServices").html(data.message);
                }
            }
        });
    });

    $(document).on('click', '.deleteCat', function () {
        $(this).parents('tr').remove();
    });


    $(document).on('click', '.addSelectCat', function () {
        $('.textForOther').hide();
        $(".appendFormData").addClass("text-center");
        var main_cat = $(".getSubCategory option:selected");

        if ($(main_cat).text() == "" || $(main_cat).text() == '---Select----') {
            $('#categoryContainer').hide();
            $('#categoryForm').show();
            return false;
        }

        var sub_cat = $(".hideSubCat option:selected");
        if ($(sub_cat).text() == "" || $(sub_cat).text() == '---Select----') {
            var subText = "---";
            var subVal = "";
        } else {
            var subText = $(sub_cat).text()
            var subVal = $(sub_cat).val()
        }

        if ($(main_cat).text() == "Other") {
//            var subText = $('.otherVal').val();
//            var subVal = $('.otherVal').val();
            $(".otherValue").val($('.otherVal').val());
        }


        var myCat = '<tr>' +
                '  <td><input hidden value="' + $(main_cat).val() + '" name="category[]">' + $(main_cat).text() + '</td>' +
                '  <td> <input hidden value="' + subVal + '" name="sub_category[]"><span class="catName">' + subText + '</span></td>' +
                '  <td><a href="#" class="deleteCat small"><i class="fas  fa-trash text-danger"></i></a></td>' +
                '  </tr>';

        $('#appendCategory').append(myCat);
        $('.getSubCategory option:eq(0)').prop('selected', true)
        $('.hideSubCat').hide();
        $('#categoryContainer').hide();
        $('#categoryForm').show();
        $('.table-responsive-sm').show();
        $('.btnChangeClass').removeClass('text-center');
        $('.btnChangeClass').removeClass('mt-5');
    });

    $(document).on('click', '.addMoreCategory', function () {
        $('#categoryContainer').show();
        $('.textForOther textarea').val('');
        $(".appendFormData ").removeClass("text-center");
        $('#categoryForm').hide();
    });


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
@endpush
