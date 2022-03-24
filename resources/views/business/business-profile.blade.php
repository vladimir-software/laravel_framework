@extends('layouts.elements.app')
@section('content')
<div class="container businesProfileContainer">          
    <div class="row"> 
        <div class="col-sm-12 my-3">
            <div class="card shadow-none border-0">
                <div class="card-body">
                    <div class="d-flex "> 
                        <h3 class=" main-heading mx-auto">My Products</h3>
                    </div>
                    @if(isset($business) && $business != '')
                    @if(array_key_exists("page_5", $business))                    
                    @if(!empty($productIndustry))
                    <hr>
                    <h5 class="sub-heading">Industry</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($productIndustry as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul> 
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_5"> <u>edit</u></a>
                        </div>
                    </div>                    
                    @endif

                    @if(!empty($productCategory))
                    <hr>
                    <h5 class="sub-heading">Products</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($productCategory as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul>
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_5"> <u>edit</u></a>
                        </div>
                    </div>                    
                    @endif                    
                    <!--SERVICES  START-->
                    @if(!empty($is_exist_pro))
                    <hr>
                    <h5 class="sub-heading">Services</h5>
                    <div class="d-flex">  
                        <ul>                           
                            @foreach($is_exist_pro as $key=> $category)
                            <li class="nav-link"><i class="fas fa-check-double"></i>
                                @if($category['cat_name'] == "Other" && $business["page_5"]['other'] != "")                                   
                                {{ $category['cat_name'] .' ('.$business["page_5"]['other'].')'}}
                                @else
                                {{ $category['cat_name']}}  {{(isset($category['sub_cat_name']) && $category['sub_cat_name'] != "")? ' => '.$category['sub_cat_name']:''}}
                                @endif 
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_5"> <u>edit</u></a>
                        </div>
                    </div> 
                    @endif
                    <!--SERVICES  END-->
                    @if(isset($business["page_5"]['description']) && $business["page_5"]['description'] != '')
                    <hr>
                    <h5 class="sub-heading">Description</h5>  
                    <div class="d-flex">
                        <span>  <li class="nav-link text-capitalize"><i class="fas fa-info-circle mr-1"></i>{{$business["page_5"]['description']}}</li></span>  
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_5"> <u>edit</u></a>
                        </div>
                    </div>         
                    @endif
                    <!--///////////////////// PRODUCTS ///////////////-->
                    @endif
                    @endif  
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex ">                       
                        <div class="ml-auto">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_5"><i class="fas fa-plus customFont"></i> <u>Add more</u></a>
                        </div>
                    </div> 
                </div>              
            </div>
        </div>

        <div class="col-sm-12 mt-3 mb-5">
            <div class="card shadow-none border-0">
                <div class="card-body">
                    <div class="d-flex"> 
                        <h3 class="card-title mx-auto main-heading">My Services</h3>  
                    </div>
                    @if(isset($business) && $business != '')

                    @if(array_key_exists("page_4", $business))
                    @if(!empty($coolServeiceIndustry))
                    <hr>
                    <h5 class="sub-heading">Industry</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($coolServeiceIndustry as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul> 
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_4"> <u>edit</u></a>
                        </div>
                    </div>                    
                    @endif

                    @if(isset($is_exist) && $is_exist != '') 
                    <hr>
                    <h5 class="sub-heading">Services</h5>
                    <div class="d-flex">
                        <ul>
                            @foreach($is_exist as $key=> $category)
                            <li class="nav-link"><i class="fas fa-check-double"></i>
                                @if($category['cat_name'] == "Other" && $business["page_4"]['other'] != "")                                   
                                {{ $category['cat_name'] .' ('.$business["page_4"]['other'].')'}}
                                @else
                                {{ $category['cat_name']}}  {{(isset($category['sub_cat_name']) && $category['sub_cat_name'] != "" )? ' => '.$category['sub_cat_name']:''}}
                                @endif 
                            <li>
                                @endforeach                          
                        </ul>
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_4"> <u>edit</u></a>
                        </div>
                    </div> 
                    @endif

                    @if(isset($business["page_4"]['category_description']) && $business["page_4"]['category_description'] != '')
                    <hr>
                    <h5 class="sub-heading">Description</h5>  
                    <div class="d-flex">
                        <span>  <li class="nav-link text-capitalize"><i class="fas fa-info-circle mr-1"></i>{{$business["page_4"]['category_description']}}</li></span> 
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_4"> <u>edit</u></a>
                        </div>
                    </div>
                    @endif

                    @endif
                </div>
                @endif
                <div class="card-footer bg-white">
                    <div class="d-flex ">                       
                        <div class="ml-auto">
                            <a href="javascript:void(0)" class="px-4 editBusinessDetail" rel="page_4"><i class="fas fa-plus customFont"></i> <u>Add more</u></a>
                        </div>
                    </div> 
                </div>
            </div>
        </div>       
    </div>          
</div>
<!-- START MODAL -->
<div class="modal fade" id="editBusinessProfileModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
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
                <div class="appendFormData">

                </div>
            </div>         
        </div>
    </div>
</div>
<!--END MODAL-->

@endsection

@push('scripts')
<style>
    html, body{
        width:100%;
        height:100%;        
    }
    body {
        background-image: url('asset/business_profile_bg.jpeg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
    } 
    #appendCategory tr td{
        color: #333!important;
    }
</style>


<script>
    $(document).on('click', '.editBusinessDetail', function () {
        var surveyId = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: "/getSurveyData",
            data: {surveyId: surveyId},
            dataType: 'html',
            success: function (data)
            {
                $('#editBusinessProfileModal').modal('show');
                $('.appendFormData').html(data);
                $(".multiple-product").select2({
                    placeholder: "--Select a product--",
                    allowClear: true
                });
                $(".multiple-industry").select2({
                    placeholder: "--Select a industry--",
                    allowClear: true
                });
                $(".js-category-industry").select2({
                    placeholder: "--Select a industry--",
                    allowClear: true
                });
            }
        });
    });

    $(document).on('submit', '.submitEditedProductServices', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/submitEditedSurvey4",
            data: $(".submitEditedProductServices").serialize(),
            dataType: 'json',
            success: function (data)
            {
                if (data.status == "success") {
                    toastr["success"](data.message);
                    setTimeout(function () {
                        window.location.href = "/business-profile"
                    }, 800);

                } else {
                    $(".errorForProductServices").removeClass("d-none");
                    $(".errorMessageForProductServices").html(data.message);
                }
            }
        });
    });
    $(document).on('submit', '.submitEditedServices', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/submitEditedSurvey3",
            data: $(".submitEditedServices").serialize(),
            dataType: 'json',
            success: function (data)
            {
                if (data.status == "success") {
                    toastr["success"](data.message);
                    setTimeout(function () {
                        window.location.href = "/business-profile"
                    }, 800);

                } else {
                    $(".errorForServices").removeClass("d-none");
                    $(".errorMessageForServices").html(data.message);
                }
            }
        });
    });

    $(document).on('click', '.deleteCat', function () {
        $(this).parents('tr').remove();
    });

    $(document).on('click', '.addSelectCat', function () {
        $('.textForOther').hide();
        //getSubCategory
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
            $(".otherValue").val($('.otherVal').val());
        }
        var myCat = '<tr>' +
                '  <td><input hidden value="' + $(main_cat).val() + '" name="category[]">' + $(main_cat).text() + '</td>' +
                '  <td> <input hidden value="' + subVal + '" name="sub_category[]">' + subText + '</td>' +
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
        $('.textForOther textarea').val('');
        $('#categoryContainer').show();
        $('#categoryForm').hide();
        $('.errorForProductServices').addClass("d-none");
        $('.errorForServices').addClass("d-none");
    });

    $(document).on('change', ".getSubCategory", function (e) {
        if ($(".getSubCategory  option:selected").text() == "Other") {
            $('.textForOther').show();
        } else {
            $('.textForOther').hide();
        }
        var catId = $(this).val();
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
                    $('.hideSubCat').hide();
                    $('.setSubCategory').html('');

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


    function countTitle(val) {
        var len = val.value.length;
        if (len >= 300) {
            val.value = val.value.substring(0, 300);
        } else {
            $('#charNum3').removeClass('d-none');
            $('#charNum3').text(300 - len);
        }
    }
    ;

</script>
<style>
    .editBusinessDetail{
        font-size: 13px;
    }
    .editServicesModal tr td{
        color: #000!important;
    }
    .appendFormData .mainHeading{
        color: #ff7c00!important;
        font-size: 17px!important;
        font-weight:600;
    }
    .select2-container{
        width: 100%!important;
    }

    .editProductModal textarea.form-control{
        font-size: 16px!important;
        color: #000!important;
    }
    .editServicesModal textarea.form-control{
        font-size: 16px!important;
        color: #000!important;
    }
    .customFont{
        font-size: 13px;
    }
</style>

@endpush
