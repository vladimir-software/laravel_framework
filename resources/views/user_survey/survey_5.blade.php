@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="card surveyBoxSize surveyBox-5  scale-up-center mt-2"> 
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
                    <div class="card-body" style="color:#333;" id="page_7">
                        <form id="submitSurvey5" method="post" action="{{route('submitSurvey5')}}" class="surveyForms" name="submitSurvey5">
                            @csrf
                            @if(!$list->isEmpty())
                            @php $c= 1; @endphp
                            @foreach($list as $key=> $qu)
                            <div class="questionDiv " @if($key != 0)style="display:none;"@endif>
                                <div class="progress mb-3" >
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"  aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (100 / count($list)) * ($c); ?>%"><?php echo 'Question ' . $c++; ?></div>
                                </div>
                                <p style="font-weight:600;font-size: 17px;" class="hideForLast">Please fill out the following questions to submit your application.</p>
                                <div class="@if($key != 0) scale-up-hor-right @endif ">
                                    <label class="form-check-label suveyLabel"  for="defaultCheck1">{{$qu->content}}</label>
                                    <input type="hidden" name="question[]" value="{{$qu->content}}">
                                    <input type="text"  class="form-control qQnswer" name="answer[]" value="{{$val['answer'][$key]}}" style="font-size:13px;margin-bottom: 1rem" required="">
                                    <div class="mt-4">
                                        @if($key != 0)
                                            <a href="#" class="btn btn-sm btn-default backQuestion" style='color:#666!important'><i class="fas fa-long-arrow-alt-left"></i> back</a>
                                        @else
                                            <a href="javascript:history.back()" class="btn btn-sm btn-primary text-white  submitSurvey mr-2"  style="padding: 3.5px 10px;"  rel="">Back</a>
                                        @endif
                                        <button type="button" class="btn btn-sm btn-success float-right nextQuestion mt-1" style="padding: 5px 11px;" >Next</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="questionDiv scale-up-hor-right" style="display:none;">
                                <div class="d-flex">
                                    <input type="checkbox" id="survey7" required="" style="">
                                    <label for="survey7" style="font-size:13px;">ConnectEO Network is a space where everyone wins. As a member of the community, you agree to respect this space, add value and treat all of the entrepreneurs with honor and respect. You understand that there is no tolerance for bullying, harassment or toxic behavior. A violation of the above will result in removal from the community.</label>
                                </div>
                                <div style="margin-top:3.6rem">
                                    <a href="#" class="btn btn-sm btn-default backQuestion" style='color:#666!important'><i class="fas fa-long-arrow-alt-left"></i> back</a>
                                    <input name="page_name" hidden="" value="page_7">
                                    <button type="submit" class="btn surveyNextButton text-white float-right" rel="">Submit</button>
                                </div> 
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
    $('.nextQuestion').on('click', function () {
        $('.errorForEmptyField').hide();
        var check = $(this).parents('.questionDiv').find(".qQnswer").val();
        if (check == "") {
            $(this).parents('.questionDiv').find(".qQnswer").css('marginBottom', '0');
            $(this).parents('.questionDiv').find(".qQnswer").after("<p class='m-0 text-danger small errorForEmptyField'>Please fill out the field</p>");
            return false;
        }
        $(this).parents('.questionDiv').hide();
        $(this).parents('.questionDiv').next(".questionDiv").show();

    });
    $('.backQuestion').on('click', function () {
        $(this).parents('.questionDiv').hide();
        $(this).parents('.questionDiv').prev(".questionDiv").show();
    });

    $(document).on('keyup paste change', '.qQnswer', function () {
        $('.errorForEmptyField').hide();
    });
</script>
<style>

    .scale-up-hor-right {
        -webkit-animation: scale-up-hor-right 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
        animation: scale-up-hor-right 0.4s cubic-bezier(0.390, 0.575, 0.565, 1.000) both;
    }
    /* ----------------------------------------------
     * Generated by Animista on 2019-11-15 19:10:52
     * Licensed under FreeBSD License.
    
     * ---------------------------------------------- */

    /**
     * ----------------------------------------
     * animation scale-up-hor-right
     * ----------------------------------------
     */
    @-webkit-keyframes scale-up-hor-right {
        0% {
            -webkit-transform: scaleX(0.4);
            transform: scaleX(0.4);
            -webkit-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
        }
        100% {
            -webkit-transform: scaleX(1);
            transform: scaleX(1);
            -webkit-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
        }
    }
    @keyframes scale-up-hor-right {
        0% {
            -webkit-transform: scaleX(0.4);
            transform: scaleX(0.4);
            -webkit-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
        }
        100% {
            -webkit-transform: scaleX(1);
            transform: scaleX(1);
            -webkit-transform-origin: 100% 100%;
            transform-origin: 100% 100%;
        }
    }


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
    }
    @media screen and (min-width:720px){
        .sign-up-bg{         
            min-height: 86vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .surveyBoxSize{
            max-height: 83vh;
            position: relative!important;
            overflow-y:scroll!important;
        }
    }

</style>
<style>
    @media only screen and (min-width:700px){
        #survey7{
            width:52px;
            height: 19px;
            margin-right: 4px; 
        }
    }
    @media only screen and (max-width:700px){
        #survey7{
            width: 78px;
            height: 19px;
            margin-right: 4px;
        }
    }    

</style>
@endpush
