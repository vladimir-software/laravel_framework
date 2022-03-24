@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div class="survey-container container w-100 ">
        <div class=" scale-up-center">
            <!--WELCOME-->
            <div class="row ">
                <div class="col-lg-5 col-md-6 col-sm-10 col-12 mx-auto">
                    <div class="card w-100 "> 
                        <div class="card-header text-center bg-white">
                            <img src="{{asset('asset/connect_eo.jpg')}}" style="width: 100px;">
                        </div>  
                        <div class="card-body text-center" style="color:#333" id="page_1">
                            <img src="{{asset($data['image'])}}" style="width: 250px;height: 90px;">
                            <h6 class="pt-3 font-weight-bold" style="">{{$data['heading']}}</h6>
                            <div class="text-center">                         
                                <p style="font-size:12px;color:#000;">{{$data['paragraph']}}</p>
                                <input name="page_name" hidden="" value="page_1">
                                <div class="mt-4">
                                    <a href="{{route('submitWelcome')}}" class="text-white  py-2 px-4 rounded welcomeForm" style="letter-spacing:.5px ;background: #404fc9 !important;font-size:13px">Continue</a>
                                </div>
                            </div>
                        </div>
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
</script>
@endpush