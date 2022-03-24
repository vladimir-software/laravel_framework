@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body">
                    <div class="d-inline-flex w-100">
                        <h4 class="card-title">Collaboration Matching Matrix</h4>
                        <div class="ml-auto ">
                            <a href="{{route('admin.bootstrap.business.matching-matrix')}}" class="small"><u>View all</u></a>
                        </div>
                    </div>                                     
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row" id="collaboration-row">
    <form method="post" action="javascript:void(0);"  class="flexForm" id="collaborationForm">
        @csrf
        <div class="col-sm-6">
            <div class="grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <label class="switch">
                            <input type="checkbox">
                            <span id="match-from-slider" class="slider"></span>
                        </label>
                        <br/><span id="match-from-title">CATEGORY</span><hr/><br/>
                        <input type="hidden" name="match-from-type" id="match-from-type" value="CATEGORY"/>
                        <div id="products-from" style="display:none;">
                            <div class="form-group">
                                <label for="productsFromSelect">Products</label>
                                <select name="product" class="form-control form-control-lg" id="productsFromSelect">
                                    <option disabled='' selected="" class="service">--Select--</option>
                                    @if(!empty($products))
                                        @foreach($products as $product)
                                            <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div id="category-from">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Category</label>
                                <select name="category" class="form-control form-control-lg getSubCategory" id="exampleFormControlSelect1">
                                    <option disabled='' selected="" class="service">--Select--</option>
                                    @if(!empty($serviceCategory))
                                        @foreach($serviceCategory as $services)
                                            <option value="{{$services['id']}}">{{$services['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>     
                            <div class="form-group mt-5">
                                <label for="exampleFormControlSelect1">Sub Category</label>
                                <select name="sub_category" class="form-control form-control-lg setSubCategory" id="exampleFormControlSelect1"></select>
                            </div>
                        </div>
                         
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="grid-margin stretch-card">
                <div class="card">              
                    <div class="card-body">  
                    
                        <label class="switch">
                            <input type="checkbox">
                            <span id="match-to-slider" class="slider"></span>
                        </label>
                        <br/><span id="match-to-title">CATEGORY</span><hr/><br/>  
                        <input type="hidden" name="match-to-type" id="match-to-type" value="CATEGORY"/>
                        <div id="products-to" style="display:none;">
                            <div class="form-group">
                                <label for="productsToSelect">Products</label>
                                <select name="related_product[]" class="form-control form-control-lg" id="productsToSelect">
                                    <option disabled='' selected="" class="service">--Select--</option>
                                    @if(!empty($products))
                                        <option value="{{count($products)}}">All</option>
                                        @foreach($products as $product)
                                            <option value="{{$product['id']}}">{{$product['name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>     
                        </div>
                        <div id="category-to">
                            <div class="form-group">
                                <label>Category</label>
                                <div class="input-group">
                                    <select name="related_category[]" class="js-multiple-service w-100 mb-3 getSubCategory" multiple="multiple">
                                        @if(!empty($serviceCategory))
                                        <option value="{{count($serviceCategory)}}">All</option>
                                        @foreach($serviceCategory as $services)
                                        <option value="{{$services['id']}}">{{$services['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mt-5">
                                <div id="hideRelatedSubCat">
                                    <label for="exampleFormControlSelect1">Sub Category</label>
                                    <select name="related_sub_category" class="form-control form-control-lg setSubCategory"></select>
                                </div>  
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>       
        </div>
    </form>
    <div class="ml-md-6 mb-6">
        <button type="submit" class="btn btn-success collaborationFormSubmit">Save</button>
    </div>
</div>
@endsection
@push('scripts')
<style>
    
    .flexForm{
        width: 100%;
    }
    
    @media screen and (min-width:600px){
        .flexForm{
            display: flex;          
        }
    }
    
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #ccc;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #ccc;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
    
</style>
<script>
    $(document).ready(function () {
        $(".js-multiple-service").select2({
            placeholder: "--Select a category--",
            allowClear: true
        });
        
        $("#match-to-slider").click(function(){
            if ($("#match-to-title").html() == 'PRODUCT') {
                $("#match-to-title").html('CATEGORY');
                $("#match-to-type").val('CATEGORY');
            } else {
                $("#match-to-title").html('PRODUCT');
                $("#match-to-type").val('PRODUCT');
            }
            $('#category-to').toggle();
            $('#products-to').toggle();            
        });

        $("#match-from-slider").click(function(){
            if ($("#match-from-title").html() == 'PRODUCT') {
                $("#match-from-title").html('CATEGORY');
                $("#match-from-type").val('CATEGORY');
            } else {
                $("#match-from-title").html('PRODUCT');
                $("#match-from-type").val('PRODUCT');
            }
            $('#category-from').toggle();
            $('#products-from').toggle();
        });
    });
    $(document).on('change', '.js-multiple-service', function () {
        var name = $('.js-multiple-service option:selected').val();       
        var count = <?php echo count($serviceCategory)?>;
        if (name == count) {
            $(".js-multiple-service").select2({
                maximumSelectionLength: 1,
                language: {
                    maximumSelected: function (e) {
                        return 'Cannot select more with the category(All).';
                    }
                }
            });
        } else {
            $(".js-multiple-service").select2({
                multiple: true
            });
        }
        $('.js-multiple-service option:selected').each(function (index, val) {
            if (index > 0) {
                $("#hideRelatedSubCat").hide();
            } else {
                $("#hideRelatedSubCat").show();
            }
        });
    });
    
    $(document).on('change', '.getSubCategory', function (e) {
        var obj = $(this);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/serviceSubCategory",
            data: {cat_id: $(this).val()},
            dataType: 'json',
            context: this,
            success: function (data) {
                if (data.data == '') {
                    $(this).parents('.card-body').find('.setSubCategory').html('');
                } else {
                    $(this).parents('.card-body').find('.setSubCategory').html('');
                    $(this).parents('.card-body').find('.setSubCategory').append('<option value="">---Select----</option>');
                    $.each(data.data, function (index, value) {
                        $(obj).parents('.card-body').find('.setSubCategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            }
        });
    });

    $(document).on('click', '.collaborationFormSubmit', function () {
        $('#collaborationForm').submit();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/saveCollaboration",
            data: $('#collaborationForm').serialize(),
            dataType: 'json',
            context: this,
            success: function (data) {
                if (data.status == 'success') {
                    $('.service').prop('selected', true);
                    $('.setSubCategory').html('');
                    Swal.fire({
                        text: "Collaboration has been saved successfully.",
                        icon: 'Success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.value) {
                            $('.js-multiple-service').val(null).trigger("change");
                            $(".js-multiple-service").select2({
                                placeholder: "--Select a category--"
                            });
                        }
                    });
                } else {
                    Swal.fire('Error!', '' + data.message + '');
                }
            }
        });
    });
</script>
@endpush
