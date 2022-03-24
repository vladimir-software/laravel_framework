@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <div class="col-lg-6 col-md-8  col-sm-10 col-12 mx-auto">
            <div class="card surveyBoxSize scale-up-center mt-2"> 
                <div class="card-header text-center bg-white">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <div>
                    <div class = "uk-margin">
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            {{$message}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body" style="color:#333;" id="page_2">
                    <form method="post" action="{{route('submitEditedSurvey1')}}" class="surveyForms">
                        @csrf   
                        <p style="font-weight:600" class="surveyHeading">Tell us about your business.</p>
                        <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">                           
                            <input class="mr-3 surveyCheckBox" name="answer[]" type="checkbox"  value="product" id="defaultCheck1" style="margin-top:4px!important;" @if(isset($answer) && in_array('product', $answer)) checked="checked"  @endif>
                                   <label class="form-check-label suveyLabel  mb-2" for="defaultCheck1">We offer products.</label>
                        </div>
                        <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">                           
                            <input class="mr-3 surveyCheckBox"  name="answer[]" type="checkbox"  value="service" id="defaultCheck2" style="margin-top: 4px!important;" @if(isset($answer) &&  in_array('service', $answer)) checked="checked"  @endif>
                                   <label class="form-check-label suveyLabel mb-2" for="defaultCheck2">We offer services.</label>
                        </div>
                        <div class="nextSurvey">
                            <a href="{{route('skipEditSurveyQuestion','page_2')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                            <input name="page_name" hidden="" value="page_2">
                            <button type="submit" class="btn surveyNextButton text-white float-right submitSurvey" rel="">Next</button>
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
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>
@endpush