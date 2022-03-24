@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">       
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="card surveyBoxSize  scale-up-center mt-2 my-md-2"> 
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
                    <div class="card-body " style="color:#333" id="page_4">
                        <p style="font-weight:600" class="surveyHeading">Tell us about your super cool service.</p>

                        <div id="categoryContainer" style="display:none;">
                            <label class="form-check-label suveyLabel" for="defaultCheck1">{{$pageData[0]['content']}}</label>
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
                            <div class="nextSurvey">
                                <!--<a href="{{route('skipEditSurveyQuestion','page_4')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>-->
                                <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
                                <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
                            </div>
                        </div>

                        <form method="post" action="{{route('submitEditedSurvey3')}}" class="surveyForms" id="categoryForm">
                            @csrf  
                            <label class="form-check-label suveyLabel" for="defaultCheck1"><b>Industry</b></label>
                            <div class="input-group"> 
                                <select name="industry[]"  class="js-multiple-industry w-100 mb-3"  multiple="multiple">
                                    @if(!empty($industry))
                                    @foreach($industry as $key=> $sat)
                                    <option value="{{$sat['id']}}" @if(isset($data1['industry'])?in_array($sat['id'], $data1['industry']):'') selected @endif>{{$sat['name']}}</option>  
                                    @endforeach 
                                    @endif
                                </select>

                            </div>
                            <label class="form-check-label suveyLabelForCat mt-3" for="defaultCheck1"><b>Category</b></label>
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
                            <div class="mt-2 mb-4 btnChangeClass">
                                <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
                            </div>
                            @else
                            <table class="table table-responsive-sm" style="display:none;">
                                <tbody id="appendCategory">

                                </tbody>
                            </table>
                            <div class="text-center mt-2 mb-4 btnChangeClass">
                                <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
                            </div>
                            @endif

                            <label class="form-check-label suveyLabel mt-3" for="defaultCheck1"><b>Description</b></label>
                            <input hidden="" value="Describe your product in detail" name="question" >
                            <textarea class="form-control"  onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data1['answer']}}"  required="required">{{$data1['answer']}}</textarea>
                            <p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>
                            <div class="nextSurvey">
                                <a href="{{route('skipEditSurveyQuestion','page_4')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                                <input name="page_name" hidden="" value="page_4">
                                <button type="submit" class="btn surveyNextButton text-white float-right" rel="">Next</button>
                                <a href="javascript:history.back()" class="btn surveyBackButton text-white float-right submitSurvey mr-2" rel="">Back</a>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>
@endpush
@push('scripts')
<script>

    $(document).on('click', '.deleteCat', function () {
        $(this).parents('tr').remove();
    });

    $(document).on('click', '.addSelectCat', function () {
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
</script>
<style>
    html, body {
        height: 100%;
    }
    body {
        /* Location of the image */
        background-image: url('asset/sign-up.jpeg');

        /* Background image is centered vertically and horizontally at all times */
        background-position: center center;

        /* Background image doesn't tile */
        background-repeat: no-repeat;

        /* Background image is fixed in the viewport so that it doesn't move when 
           the content's height is greater than the image's height */
        background-attachment: fixed;

        /* This is what makes the background image rescale based
           on the container's size */
        background-size: cover;

        /* Set a background color that will be displayed
           while the background image is loading */
        background-color: #464646;      
    }  
    .card{
        top: 0%!important;
    }
    .surveyBoxSize::-webkit-scrollbar { 
        display: none; 
    }

    @media screen and (min-width:720px){
        .sign-up-bg{         
            min-height: 86vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .surveyBoxSize{
            max-height: 80vh;
            position: relative!important;
            overflow-y:scroll!important;
        }

    }
    @media only screen and (max-width:500px){
        .surveyBoxSize{
            position: relative!important;
            overflow-y:scroll!important;
            min-height:90%;
        }
    }
</style>
<script>
    $(".getSubCategory").on('change', function (e) {
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

    function countChar2(val) {
        var len = val.value.length;
        if (len >= 2000) {
            val.value = val.value.substring(0, 2000);
        } else {
            $('#charNum2').text(2000 - len);
        }
    }
    ;
    /////////////////////////////////
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

@endpush