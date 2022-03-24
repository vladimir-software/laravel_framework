@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="card surveyBoxSize  scale-up-center my-2"> 
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
                    <div class="card-body " style="color:#333" id="page_5">
                        <form method="post" action="{{route('submitEditedSurvey4')}}" class="surveyForms" >
                            @csrf
                            <label class="form-check-label suveyLabel mt-3" for="defaultCheck1">{{$pageData[1]['content']}}</label>
                            <div class="input-group">
                                <select name="industry[]"  class="js-multiple-industry w-100 mb-3"  multiple="multiple">                                   
                                    @if(!empty($industry))
                                    @foreach($industry as $key=> $sat) 
                                    <option value="{{$sat['id']}}" 
                                            @if(isset($data['industry'])) 
                                            @php echo in_array($sat['id'], $data['industry']) ? 'selected=selected' : '' @endphp
                                            @endif 
                                            >{{$sat['name']}}</option>  
                                    @endforeach 
                                    @endif
                                </select>
                            </div> 
                            <p style="font-weight:600" class="surveyHeading">Tell us about your awesome product.</p>
                            <label class="form-check-label suveyLabel"  for="defaultCheck1">{{$pageData[0]['content']}}</label>
                            <div class="input-group">    
                                <select name="type_of_product[]"  class="js-multiple-product w-100 mb-3"  multiple="multiple">
                                    @ph
                                    @if(!empty($productCategory))
                                    @foreach($productCategory as $key=> $pat)
                                    <option value="{{$pat['id']}}" 
                                            @if(isset($data['type_of_product'])) 
                                            @php echo in_array($pat['id'], $data['type_of_product']) ? 'selected=selected' : '' @endphp
                                            @endif 
                                            >{{$pat['name']}}</option>  
                                    @endforeach
                                    @endif
                                </select>
                            </div>                          
                            <label class="form-check-label suveyLabel mt-3" for="defaultCheck1">{{$pageData[2]['content']}}l</label>
                            <input hidden="" value="Describe your product in detail" name="question" >
                            <textarea class="form-control"  onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data['answer']}}" required="required">{{$data['answer']}}</textarea>
                            <p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>
                            <div class="nextSurvey">
                                <a href="{{route('skipEditSurveyQuestion','page_5')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                                <input name="page_name" hidden="" value="page_5">
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
<style>
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
<style>
    html, body {
        height: 100%;
    }

    .card{
        top: 0%!important;
    }
    .surveyBoxSize::-webkit-scrollbar { 
        display: none; 
    }
    @media screen and (min-width:720px){
        .sign-up-bg{
            min-height: 100%;  /* Fallback for vh unit */
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
<script>
    if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>
@endpush