@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto ">
            <div class="card surveyBoxSize scale-up-center  mt-md-5 mt-2"> 
                <div class="card-header text-center bg-white">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <div class = "uk-margin">
                    @if ($message = Session::get('error'))
                    <div class="alert alert-danger text-center" role="alert">
                        {{$message}}
                    </div>
                    @endif
                </div>
                <div class="card-body text-dark" id="page_01">
                    <p style="font-weight:600" class="surveyHeading">Tell us about services you're interested in obtaining.</p>
                    <div id="categoryContainer" style="display:none;">
                        <label class="form-check-label suveyLabel" for="defaultCheck1">{{$pageData[0]['content']}}</label>
                        <div>
                            <div class="input-group">                                       
                                <select name="category" class="custom-select getSubCategory mb-3" >                                    
                                    <option value="" >---Select----</option>  
                                    @if(!empty($serviceCategory))
                                    @foreach($serviceCategory as $cat)                                    
                                    <option value="{{$cat['id']}}">{{$cat['name']}}</option>  
                                    @endforeach
                                    @endif
                                </select>
                            </div>     
                            <div class="hideSubCat" style="display:none;">
                                <label class="form-check-label suveyLabel" for="defaultCheck1">{{$pageData[1]['content']}}</label>
                                <div class="input-group">                                       
                                    <select name="sub_category" class="custom-select setSubCategory" >
                                        <option value="">---Select----</option> 
                                        @if(!empty($serviceSubCategory))                                            
                                        @foreach($serviceSubCategory as $cat2)
                                        <option value="{{$cat2['id']}}">{{$cat2['name']}}</option>  
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div style="display:none;" class="textForOther">
                                <label class="form-check-label suveyLabel" style="color: #333;" for="otherVal">Description</label>   
                                <textarea  class="otherVal w-100 pl-2"></textarea>
                            </div>
                            <div class="appendErrorForSameServies text-center text-danger mt-3"></div>
                        </div>
                        <div class="nextSurvey">
                            <a href="{{route('skipSurveyQuestion','pageForObtainBusiness')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                            <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
                            <a href="javascript:void(0);" onclick=" $('#categoryContainer').hide(); $('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
                        </div>
                    </div>
                    <form method="post" action="{{route('submitSurvey01')}}" class="surveyForms" id="categoryForm">
                        @csrf
                        <input name="other" hidden="" value="" class="otherValue">  
                        @if(!empty($data))
                        <table class="table table-responsive-sm">
                            <tbody id="appendCategory">
                                @foreach($data as $dd)
                                <tr>  
                                    <td>
                                        <input hidden="" value="{{$dd['cat_id']}}" name="category[]">{{$dd['cat_name']}}
                                    </td>
                                    <td> 
                                        <input hidden="" value="{{$dd['sub_cat_id']}}" name="sub_category[]">{{isset($dd['sub_cat_name'])? $dd['sub_cat_name'] :"---"}}
                                    </td>  
                                    <td>
                                        <a href="#" class="deleteCat small"><i class="fas  fa-trash text-danger"></i></a>
                                    </td>  
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5 mb-5 btnChangeClass">
                            <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
                        </div>
                        @else
                        <table class="table table-responsive-sm" style="display:none;">
                            <tbody id="appendCategory">

                            </tbody>
                        </table>
                        <div class="text-center mt-5 mb-5 btnChangeClass">
                            <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
                        </div>
                        @endif

                        <div class="nextSurvey">
                            <a href="{{route('skipSurveyQuestion','pageForObtainBusiness')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                            <input name="page_name" hidden="" value="pageForObtainBusiness">
                            <button type="submit" class="btn surveyNextButton text-white float-right" rel="">Next</button>
                            <a href="javascript:history.back()" class="btn surveyBackButton text-white float-right submitSurvey mr-2" rel="">Back</a>
                        </div>   
                    </form>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<style>
    body {
        background-image: url('asset/sign-up.jpeg');
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        background-color: #464646;
    }
    tr td{
        font-size: 14px!important;
    }

</style>
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>
<script>
    $(document).on('click', '.deleteCat', function () {
        $(this).parents('tr').remove();
    });


    $(document).on('click', '.addSelectCat', function () {
        $('.textForOther').hide();
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
        $('#categoryContainer').show();
        $('#categoryForm').hide();
    });

    $(document).on('change', ".getSubCategory", function (e) {
        if ($(".getSubCategory  option:selected").text() == "Other") {
            $('.textForOther').show();
        } else {
            $('.textForOther').hide();
        }
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

</script>

@endpush