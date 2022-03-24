@extends('layouts.elements.app')
@section('content')
<div class="container moreObtainMatches" id="connection">
    <div class="row my-5">
        <div class="col-sm-12"><h2 class="text-center">Businesses That Need You</h2></div>        
        @if(count($usersForProvideServices) < 1)
            <br/><br/><br/>
            <div class="col-sm-12"><h5 class="text-center"><i class="far fa-clock"></i> Please Check back later for more matches...</h5></div>
        @endif
        @if(count($usersForProvideServices) >=1)
        @php $i=1;@endphp
        @foreach($usersForProvideServices as $key=>  $data) 
        <div class="col-md-3  mb-5 mb-lg-0 d-flex align-items-stretch">
            <div class="card card-profile mt-4"> 
                <div class="card-body p-0  userRating d-flex flex-column">                   
                    <div class="text-center  py-3">
                        <img src="{{$data['profile_pic']}}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 150px;height:150px">
                        <div class="pt-4 userConnectionDataContainer">
                            <h5 class="title">
                                <span class="d-block mb-1">
                                    <a href="javacript:void(0);" style="color: #ff7c00!important;" class="text-capitalize companyName">
                                        {{($data['company_name'] != '')?$data['company_name']:""}}
                                    </a>
                                </span>
                                <div class="d-flex justify-content-center text-capitalize">
                                    <a href="{{route('user-profile',$data['token'])}}"  class="borderRadius" style="font-size: 13px;">view profile</a>
                                    @if(isset($data['location_address']))
                                        <span class="px-1" style="font-size: 13px;">|</span>
                                        <p class="m-0 small" style="font-size: 13px; white-space: nowrap; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">{{(isset($data['location_address']) ? $data['location_address'] : "")}}</p>                                    
                                    @endif   
                                </div>
                            </h5>
                            <div><span style="color:#000">You Need Them</span>                                                   
                                <div class="owl-carousel-provide-more owl-carousel">
                                    @foreach($data['catSubCat'] as $key=>$c)
                                    <div class="item" style="margin: 0px 10px;">
                                        <span class="badge badge-primary px-3 py-1" style="white-space: pre-wrap;font-size:11px">{{$c}}</span>
                                    </div>                        
                                    @endforeach     
                                </div>          
                            </div>  
                            <div class="relationDetails">
                                @if(isset($data['cat_id']) && $data['cat_id'] != '')
                                @foreach($data['cat_id'] as $key=>$c1)
                                @php  $m="provide:".$c1.",".(isset($data['sub_cat_id'][$key])?$data['sub_cat_id'][$key]:''); @endphp    
                                <input class="relation" value="{{$m}}" id="user_id" hidden="">
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div> 
        @endforeach
        @endif
    </div>
</div>
@endsection
@push('scripts')
<style>
    .badge{
        border-radius: 1rem;
        /*font-size: 0.65rem;*/
        font-weight: initial;
        line-height: 1;
        padding: 0.2rem 0.3rem;
        font-family: "Poppins", sans-serif;
        font-weight: 600;
        background: #ff7c00!important;
        color: #fff;
    }
    .badge-success, .preview-list .preview-item .preview-thumbnail .badge.badge-online {
        color: #fff;
        background-color: #ed1c24;
    }
</style>

<script>
    var owlss = $('.owl-carousel-provide-more');
    owlss.owlCarousel({
        autoplay: false,
        center: true,
        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            },
            1300: {
                items: 1
            }
        }
    });
</script>
@endpush
