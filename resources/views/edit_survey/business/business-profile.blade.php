@extends('layouts.elements.app')
@section('content')

<div class="container businesProfileContainer">          
    <div class="row"> 
        @if(isset($business) && $business != '')
        @if(isset($business[0]['answer']) && $business[0]['answer'] !== '')
        @if(in_array('product',$business[0]['answer']))
        <div class="col-sm-12 my-3">
            <div class="card shadow-none border-0">
                <div class="card-body">
                    <div class="d-flex "> 
                        <h3 class=" main-heading ml-auto">My Products</h3> 
                        <div class="ml-auto"><a href="javascript:void(0)" class="btn btn-success px-4 editBusinessDetail" rel="page_5">Edit</a></div>
                    </div> 
                    @foreach($business as $products)


                    @if(isset($products['page_name']) && $products['page_name'] == 'page_5')
                    @if(isset($products['answer']) && $products['answer'] != '') 

                    @if(!empty($productIndustry))
                    <hr>
                    <h5 class="sub-heading">Industry</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($productIndustry as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul> 
                    </div>                    
                    @endif

                    @if(isset($productCategory) && $productCategory != '')
                    <hr>
                    <h5 class="sub-heading">Products</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($productCategory as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul> 
                    </div>                    
                    @endif



                    @if(isset($products['description']) && $products['description'] != '')
                    <hr>
                    <h5 class="sub-heading">Description</h5>  
                    <span>  <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$products['description']}}</li></span>                  
                    @endif

                    @endif
                    @endif


                    @endforeach                   
                </div>
            </div>
        </div>
        @endif
        @endif
        @endif


        @if(isset($business) && $business != '')                   
        @if(isset($business[0]['answer']) && $business[0]['answer'] !== '')
        @if(in_array('service',$business[0]['answer']))
        <div class="col-sm-12 my-3">
            <div class="card shadow-none border-0">
                <div class="card-body">
                    <div class="d-flex "> 
                        <h3 class="card-title text-center  main-heading">My Services</h3>  
                        <div class="ml-auto"><a href="javascript:void(0)" class="btn btn-success px-4 editBusinessDetail" rel="page_4">Edit</a></div>
                    </div>
                                 

                    @foreach($business as $services)

                    @if(isset($services['page_name']) && $services['page_name'] == 'page_4')
                    @if(isset($services['answer']) && $services['answer'] != '')

                    @if(!empty($coolServeiceIndustry))
                    <hr>
                    <h5 class="sub-heading">Industry</h5>  
                    <div class="d-flex">  
                        <ul>
                            @foreach($coolServeiceIndustry as $key=> $product)
                            <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$product['name']}}</li>
                            @endforeach
                        </ul> 
                       
                    </div>                    
                    @endif

                    @if(isset($is_exist) && $is_exist != '') 
                    <hr>
                    <h5 class="sub-heading">Services</h5>
                    <div class="d-flex">  
                        <ul>
                            @foreach($is_exist as $key=> $category)
                            <li class="nav-link"><i class="fas fa-check-double"></i> {{$category['cat_name']}} {{isset($category['sub_cat_name'])? ' => '.$category['sub_cat_name']:''}}</li>
                            @endforeach
                        </ul>
                    </div> 
                    @endif



                    @if(isset($services['category_description']) && $services['category_description'] != '')
                    <hr>
                    <h5 class="sub-heading">Description</h5>  
                    <span>  <li class="nav-link text-capitalize"><i class="fas fa-check-double"></i> {{$services['category_description']}}</li></span>                  
                    @endif


                    @endif
                    @endif
                    @endforeach       
                </div>
            </div>
        </div>
        @endif
        @endif
        @endif

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

    $(document).on('click', '.deleteCat', function () {
        $(this).parents('tr').remove();
    });

    $(document).on('click', '.addSelectCat', function () {
        //getSubCategory
        var main_cat = $(".getSubCategory option:selected");
        if ($(main_cat).text() == "" || $(main_cat).text() == '---Select----') {
            $('#categoryContainer').hide();
            $('#categoryForm').show();
            $('.d-hide').addClass('d-none');
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
        $('#categoryContainer').show();
        $('.d-hide').removeClass('d-none');
        $('#categoryForm').hide();
    });

    $(document).on('change', ".getSubCategory", function (e) {

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
                } else {
                    $('.hideSubCat').show();
                    $('.setSubCategory').html('');
                    $('.setSubCategory').append('<option value="">---Select----</option>');
                    $.each(data.data, function (index, value) {
                        $('.setSubCategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
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
</style>

@endpush