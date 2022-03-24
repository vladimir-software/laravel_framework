@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">    
        <!--WELCOME-->           
        <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
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
                <!--THIRD QUESTION-->
                <div class="card-body" style=";color:#333" id="page_3">
                    <form method="post" action="{{route('submitSurvey1')}}" class="surveyForms">
                        @csrf
                        <p style="font-weight:600" class="surveyHeading">What is your primary goal?</p>
                        @if(isset($data) && $data != "")
                        @foreach($data as $key=> $value)
                        <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">
                            <input class=" mr-3 surveyCheckBox" name="answer[]" type="checkbox"  value="{{$value['content']}}" id="defaultCheck{{$key}}" style="margin-top: 0.3rem !important;"  @if(isset($val) && in_array($value['content'],$val)) checked @endif>
                                   <label class="form-check-label mb-2 suveyLabel" for="defaultCheck{{$key}}">{{$value['content']}}</label>
                        </div>
                        @endforeach
                        @endif
                        <div class="nextSurvey">
                            <a href="{{route('skipSurveyQuestion','page_3')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                            <input name="page_name" hidden="" value="page_3">                                    
                            <button type="submit" class="btn surveyNextButton text-white float-right submitSurvey" rel="">Next</button>
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

</style>
@endpush

