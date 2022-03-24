@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">       
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="card surveyBoxSize scale-up-center mt-2"> 
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
                                <a href="{{route('skipEditSurveyQuestion','pageForObtainBusiness')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                                <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
                                <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
                            </div>
                        </div>
                        <form method="post" action="{{route('submitEditedSurvey02')}}" class="surveyForms" id="categoryForm">
                            @csrf
                            @if(!empty($data))
                            <table class="table table-responsive-sm">
                                <tbody id="appendCategory">
                                    @foreach($data as $dd)
                                    <tr>  
                                        <th>
                                            <input hidden="" value="{{$dd['cat_id']}}" name="category[]">{{$dd['cat_name']}}
                                        </th>
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
                                <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
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
                                <a href="{{route('skipEditSurveyQuestion','pageForObtainBusiness')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                                <input name="page_name" hidden="" value="pageForObtainBusiness">
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

@push('scripts')
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }

    //

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
                '  <th><input hidden value="' + $(main_cat).val() + '" name="category[]">' + $(main_cat).text() + '</th>' +
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

    @media screen and (min-width:720px){
        .sign-up-bg{
            min-height: 100%;  /* Fallback for vh unit */
            min-height: 86vh;
            display: flex;
            justify-content: center;
            align-items: center;
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
</script>

@endpush