@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="container">
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-10 col-12 mx-auto">
                <div class="card w-100 scale-up-center my-2"> 
                    <div>
                        @if ($errors->any())
                        {{ implode('', $errors->all('<div>Please select one</div>')) }}
                        @endif
                    </div>
                    <div class="card-body"  style="color:#333;" id="page_8">                  
                        <div class="text-center">
                            @if(isset(auth()->user()->fullname) && auth()->user()->fullname != '')
                            <h5 class="bold">Congrats {{Auth::user()->fullname}}!</h5>
                            @else
                            <h5 class="bold">Congrats!</h5>
                            @endif
                            <p style="font-size:12px;color:#000;">Your application has been successfully submitted <br>and you'll hear back from us soon.</p>
                            <input name="page_name" hidden="" value="page_8">
                            <button type="submit" class="btn surveyNextButton text-white completeSurveyForm " rel="">View FAQs</button>
                        </div>                   
                    </div>
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
<style>
    @media(min-width:700px){
        .survey-container {
            margin-top: -170px;
        }
    }
    @media(max-width:700px){
        .card {
            margin-top: 140px;
        }
    }
</style>
<script>
    $(".completeSurveyForm").on('click', function (e) {
        var pageId = $(this).parents(".card-body").find('input').val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/completeSurveyForm",
            data: {pageId: pageId},
            dataType: 'json',
            context: this,
            success: function (data) {
                $(this).parents(".card-body").remove();
                window.location.href = '/FAQ';
            }
        });
    });
</script>
@endpush
