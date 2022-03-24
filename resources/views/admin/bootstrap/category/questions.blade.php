@extends('admin.layouts.elements.app')
@section('content')
<div class="container">
    <div class="row">
        <!-- Normal Table area Start-->
        <div class="normal-table-area">
            <div class="container">               
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                       
                        <form method="post" action="javascript:void(0);" class="submitQuestionsForm">
                            @csrf
                            <div class="normal-table-list mg-t-30">
                                <div class="basic-tb-hd" style="display:flex;">
                                    <h2>Add Questions</h2> 
                                </div>
                                <div class="nk-int-mk sl-dp-mn" style="margin-bottom: 1rem;">
                                    <h2>Select Category</h2>
                                </div>
                                <div class="bootstrap-select fm-cmp-mg" style="padding-left:.5rem">
                                    <select name="selected_category" class="categories" tabindex="-98" style="width:100%!important;opacity:1 !important;position: initial!important">
                                        <option>choose...</option>
                                        @foreach($provideCategory as $cat)
                                        <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>                           
                            </div>
                            <div class="normal-table-list mg-t-30 addQuestion" style="display:none">                           
                                <div class="nk-int-mk sl-dp-mn" style="margin-bottom: 1rem;">
                                    <h2>Add a question</h2>
                                </div>
                                <div class="form-group appendError">
                                    <div class="nk-int-st">
                                        <input type="text" name="input_question" class="form-control input-sm input-question" placeholder="Write your question.."  autocomplete="off" required="">
                                    </div>
                                </div>
                                <div class="nk-int-mk sl-dp-mn" style="margin-bottom: 1rem;">
                                    <h2>Please select type</h2>
                                </div>
                                <div class="form-group">
                                    <div class="nk-int-st">
                                        <select class="questionType" tabindex="-98" style="width:100%!important;opacity:1 !important;position: initial!important;border: none;">
                                            <option class="defaultSelect">choose...</option>
                                            <option value="radio button">Radio Button</option>
                                            <option value="checkbox">Check Box</option>
                                            <option value="input">Input</option>
                                            <option value="selectbox">Select Box</option>
                                        </select> 
                                    </div>
                                </div> 
                            </div> 
                            <div class="normal-table-list mg-t-30 questionSubPart" style="display:none;">                          
                                <div class="nk-int-mk sl-dp-mn" style="margin-bottom: 1rem;">
                                    <h2>Question sub part</h2>
                                </div>                             
                            </div>
                            <button type="submit" class="btn notika-btn-cyan waves-effect submitButton" style="color:#fff;width: 100%;margin-top:1rem;display: none">Submit</button>
                        </form>
                    </div>                        
                </div>
            </div> 
        </div>
    </div>
    <style>
        h4{
            margin-right: 1rem;
        }
        .card{
            width: 400px;
            box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12);
            padding: 1rem;
        }
    </style>
    <script src="{{asset('js/jquery-1.12.4.min.js')}}"></script>
    <script>
$(document).on('click', '.addCategory', function () {
    $(".categoryName").val('');
    $("#addCategoryModal").modal('show');
});
//submitCategory
$(document).on('click', '.submitCategory', function () {
    var catName = $(this).parent().siblings().find('input[type="text"]').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/admin/add-category",
        data: {cat_name: catName},
        dataType: 'json',
        context: this,
        success: function (data)
        {
            if (data.message == 'success') {
                $(".appendCategory").append('<tr><td>' + data.category.id + '</td><td>' + data.category.name + '</td></tr>');
            } else if (data.status == 'failed') {
                toastr["error"](data.message);
            }
        }
    });
});
///categories

$(document).on('change', '.categories', function () {
    var val = $(this).val();
    $(".addQuestion").show();
});
$(document).on('change', '.unChecked', function () {
    $(this).prop('checked', true)
});

$(document).on('keyup', '.input-question', function () {
    $(".removeError").remove();
});
$(document).on('click', '.removeSubCategory', function () {
    $(this).parents('.form-group').remove();
});
//removeSubCategory
$(document).on('change', '.questionType', function () {
    if ($(".input-question").val() == '') {
        $(".appendError").append('<div class="removeError"><p style="color:red;font-size:12px">Question required..</p></div>');
        return false;
    }
    $(".submitButton").show();
    var val = $(this).val();
    $(".questionSubPart").show();
    if (val == 'checkbox') {
        $(".questionSubPart").append('<div class="form-group">\n\
<div class="nk-int-st" style="display:flex;">\n\
<input type="checkbox" value="checkbox"  class="unChecked" checked="" class="i-checks" style="margin-right:1rem;margin-top: .5rem;" name="input_sub_part_type[]">\n\
<input type="text" name="input_sub_part_q[]" required="" class="form-control input-sm" placeholder="Write your question category..">\n\
\n\<i class="fa fa-times btn btn-success removeSubCategory" aria-hidden="true"></i></div></div>');
    } else if (val == 'input') {
        $(".questionSubPart").append(' <div class="form-group">\n\
    <div class="nk-int-st" style="display:flex;">\n\
<input type="hidden" name="input_sub_part_type[]" value="inputBox"><i class="fa fa-pencil" aria-hidden="true"  style="margin-right:1rem;margin-top: .5rem;"></i>\n\
<input type="text"  name="input_sub_part_q[]" class="form-control input-sm" placeholder="Write your question category..">\n\
    <i class="fa fa-times btn btn-success removeSubCategory" aria-hidden="true"></i></div></div>');
    } else if (val == 'radio button') {
        $(".questionSubPart").append(' <div class="form-group">\n\
    <div class="nk-int-st" style="display:flex;">\n\
<input type="hidden" value="radioButton" name="input_sub_part_type[]"><i class="fa fa-check-circle"  style="margin-right:1rem;margin-top: .5rem;"></i> \n\
<input type="text" name="input_sub_part_q[]" required=""  class="form-control input-sm" placeholder="Write your question category..">\n\
    <i class="fa fa-times btn btn-success removeSubCategory" aria-hidden="true"></i></div></div> ');
    } else {

    }
    $(".defaultSelect").prop('selected', true);

});

$(document).on('submit', '.submitQuestionsForm', function () {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/admin/submit-question",
        data: $(".submitQuestionsForm").serialize(),
        dataType: 'json',
        context: this,
        success: function (data)
        {
            if (data.status == 'success') {
                alert(data.message);
                location.reload();
            } else {
                alert(data.message);
            }
        }
    });
});



    </script>

    @endsection