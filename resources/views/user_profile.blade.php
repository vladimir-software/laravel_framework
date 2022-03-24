@extends('layouts.elements.app')
@section('content')
<div class="position-relative userProfile">
    <div class="main-content my-3">
        <!-- Header -->
        <div class="header pb-3 pt-2 pt-lg-3 d-flex align-items-center" style="min-height: 100px;">
            <!-- Mask -->
            <span class="mask opacity-8"></span>
            <!-- Header container -->
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--7">
            <div class="row">
                <div class="col-xl-7 mx-auto mb-md-5 mb-xl-0">
                    <div class="card card-profile  mb-3">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img id="main-user-image" src="{{isset($userData['profile_pic'])? asset($userData['profile_pic']) :asset('asset/noimage_person.png')}}" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0  pt-md-4  pb-5 px-1 px-md-3"></div>
                        <div class="card-body" style="text-align:center;">
                                <div class="row">                                 
                                    <div class="col-12 pl-2 pt-3" style="text-align:left;">  
                                        <div class="d-flex justify-content-between" style="height: 30px;">
                                        @if($userConnected > 1)
                                            <span class=""><i class="fas fa-check"></i> Connected</span>
                                        @elseif((isset($connection['review_status']) && $connection['review_status'] == 1))
                                                <span classbtn btn-sm btn-primary "><i class="fas fa-clock" aria-hidden="true"></i> Pending</span>   
                                        @elseif(isset($connection['review_status']) && $connection['review_status'] == 0)
                                            <div>
                                                <i class="fas fa-ban"></i> Skipped<br/>
                                                <a href="javascript:void(0);" style="clear:both; margin-left:25px;" class="btn btn-sm btn-secondary connectUser"><i class="fas fa-user-plus"></i> Re-Connect</a>
                                            </div>
                                        @else
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary connectUser"><i class="fas fa-user-plus"></i> Connect</a>
                                        @endif   
                                        <div class="float-right">
                                            @if($userConnected > 1)
                                                @if(empty(auth()->user()->subscription_type) || auth()->user()->subscription_type == 1)
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-success  notAuthorizedForMessaging"><i class="fas fa-envelope"></i> Message</a>
                                                @else
                                                    <a href="javascript:void(0);" class="btn btn-sm btn-success modalForMessaging"><i class="fas fa-envelope"></i> Message</a>                               
                                                @endif                                    
                                            @else
                                                <a href="javascript:void(0);" class="btn btn-sm btn-success  notAuthorizedForMessaging"><i class="fas fa-envelope"></i> Message</a>
                                            @endif
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary submitReview"><i class="fas fa-pencil-alt"></i> Submit Review</a>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary submitReview submitReviewForMobile" style="display:none;"> <i class="fas fa-pencil-alt"></i> Review</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <form action="/create-project" method="post" class="userMessage">
                                @csrf
                                <input type="hidden" name="token" value="{{$userData['token']}}"/>
                                @if(!empty($projectId))
                                    <br/><a href="/project/{{$projectId}}" type="button" class="btn btn-sm btn-secondary" style="float:left; color:white;"><i class="fas fa-project-diagram"></i> Manage Project</a>
                                @else
                                     @if($userConnected > 1)                                
                                        <br/><button type="submit" class="btn btn-sm btn-secondary" style="float:left;"><i class="fas fa-project-diagram"></i> Start Project</button>
                                    @endif
                                @endif
                            </form>
                            
                            <div style="clear:both;">
                                <br/><br/>
                                <h4 class="text-capitalize custom-text mb-0">
                                    {{isset($userData['fullname'])?$userData['fullname']:'Unknown'}}<span class="font-weight-light"></span>
                                </h4>
                                @for($i = 1; $i <= $overallRatingScore; $i++)
                                    <div class="jq-star" style="width:22px; height:22px;">
                                       <svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve">
                                          <style type="text/css">.svg-empty-347{fill:url(#347_SVGID_1_);}.svg-hovered-347{fill:url(#347_SVGID_2_);}.svg-active-347{fill:url(#347_SVGID_3_);}.svg-rated-347{fill:#52cb7c;}</style>
                                          <linearGradient id="347_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                             <stop offset="0" style="stop-color:lightgray"></stop>
                                             <stop offset="1" style="stop-color:lightgray"></stop>
                                          </linearGradient>
                                          <linearGradient id="347_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                             <stop offset="0" style="stop-color:orange"></stop>
                                             <stop offset="1" style="stop-color:orange"></stop>
                                          </linearGradient>
                                          <linearGradient id="347_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                             <stop offset="0" style="stop-color:#FEF7CD"></stop>
                                             <stop offset="1" style="stop-color:#FF9511"></stop>
                                          </linearGradient>
                                          <polygon data-side="center" class="svg-empty-347" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon>
                                          <polygon data-side="left" class="svg-active-347" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon>
                                          <polygon data-side="right" class="svg-active-347" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon>
                                       </svg>
                                    </div>
                                @endfor                            
                                @if ($overallRatingScore > 1)
                                    ({{intval($overallRatingScore)}}/5)
                                @endif
                                <div class="font-weight-300 small">
                                    <i class="fas fa-map-marker-alt"></i>
                                    @if(empty($userData->userProfile['location_address1']) && empty($userData->userProfile->location_city) && empty($userData->userProfile->location_state) && empty($userData->userProfile->location_zipcode))
                                    <span style="color: #000;">Not Available</span>
                                    @else
                                    <span style="color: #000;">{{isset($userData->userProfile['location_address1'])?$userData->userProfile['location_address1']:''}}
                                        {{isset($userData->userProfile->location_city)?$userData->userProfile->location_city:''}}
                                        {{isset($userData->userProfile->location_state)?$userData->userProfile->location_state:''}}
                                        {{isset($userData->userProfile->location_zipcode)?$userData->userProfile->location_zipcode:''}}</span>
                                    @endif
                                </div>
                                <p>{{isset($userData['description'])?$userData['description']:''}}</p>
                            </div>
                            <div class="userProvides"> 
                                @if(isset($business) && $business != '') 
                                <div class="row">
                                    @if(array_key_exists("pageForObtainBusiness", $business))                                   
                                        @if(!empty($business['pageForObtainBusiness']['obtain_cat_name']))                                 
                                            <div class="col border-top pt-3 pl-2">
                                                <h5 style="color: #ff7c00;font-weight: 600;">What They'd Like to Obtain</h5>  
                                                <div class="">  
                                                    <ul>
                                                        @foreach($business['pageForObtainBusiness']['obtain_cat_name'] as $key=> $obt)
                                                        <li class="nav-link text-capitalize">                                                   
                                                            {{$obt}}  {{isset($business['pageForObtainBusiness']['obtain_sub_cat_name'][$key])? ' => '.$business['pageForObtainBusiness']['obtain_sub_cat_name'][$key]:''}}
                                                        </li>
                                                        @endforeach
                                                    </ul> 
                                                </div>   
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <!--What They'd Like to Obtain-->             
                                <div class="row">                                 
                                    <div class="col-12 border-top pl-2 pt-3">  
                                        <h5 style="color: #ff7c00;font-weight: 600;">Their Offerings</h5>  
                                        @if(array_key_exists("page_4", $business))                                   
                                            @if(!empty($business['page_4']['service_cat_name']))
                                                <ul class="mb-0">
                                                    @foreach($business['page_4']['service_cat_name'] as $key=> $ser)
                                                    <li class="nav-link text-capitalize">                                               
                                                        {{$ser}}  {{isset($business['page_4']['service_sub_cat_name'][$key])? ' => '.$business['page_4']['service_sub_cat_name'][$key]:''}}
                                                    </li>                                                   
                                                    @endforeach                                               
                                                </ul>                                         
                                            @endif
                                        @endif
                                        @if(array_key_exists("page_5", $business))                                   
                                            @if(!empty($business['page_5']['pro_service_cat_name']))
                                                <ul>
                                                    @foreach($business['page_5']['pro_service_cat_name'] as $key=> $ser)
                                                    <li class="nav-link text-capitalize">
                                                        {{$ser}}  {{isset($business['page_5']['pro_service_sub_cat_name'][$key])? ' => '.$business['page_5']['pro_service_sub_cat_name'][$key]:''}}
                                                    </li>                                                   
                                                    @endforeach                                               
                                                </ul>                                         
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <!--User Reviews-->             
                                <div class="row">                                 
                                    <div class="col-12 border-top pl-2 pt-3" style="text-align:left;">  
                                        <h5 style="color: #ff7c00;font-weight: 600;">User Reviews</h5>  
                                            @foreach($overallUserRatings as $key => $userRating)
                                            <div>
                                                <a href="/user-profile/{{$userRating->userThatRated['token']}}">
                                                    <img src="{{isset($userRating->userThatRated['profile_pic'])? asset($userRating->userThatRated['profile_pic']) :asset('asset/noimage_person.png')}}" class="rounded-circle" style="width:50px;height: 50px">
                                                </a>
                                                {{$userRating->userThatRated['fullname']}} <br/> {{$userRating->userThatRated['company_name']}}
                                            </div>
                                                @for($i = 1; $i <= $userRating->rating; $i++)
                                                    <div class="jq-star" style="width:22px; height:22px;">
                                                       <svg version="1.0" class="jq-star-svg" shape-rendering="geometricPrecision" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="305px" height="305px" viewBox="60 -62 309 309" style="enable-background:new 64 -59 305 305; stroke-width:4px;" xml:space="preserve">
                                                          <style type="text/css">.svg-empty-347{fill:url(#347_SVGID_1_);}.svg-hovered-347{fill:url(#347_SVGID_2_);}.svg-active-347{fill:url(#347_SVGID_3_);}.svg-rated-347{fill:#52cb7c;}</style>
                                                          <linearGradient id="347_SVGID_1_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                                             <stop offset="0" style="stop-color:lightgray"></stop>
                                                             <stop offset="1" style="stop-color:lightgray"></stop>
                                                          </linearGradient>
                                                          <linearGradient id="347_SVGID_2_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                                             <stop offset="0" style="stop-color:orange"></stop>
                                                             <stop offset="1" style="stop-color:orange"></stop>
                                                          </linearGradient>
                                                          <linearGradient id="347_SVGID_3_" gradientUnits="userSpaceOnUse" x1="0" y1="-50" x2="0" y2="250">
                                                             <stop offset="0" style="stop-color:#FEF7CD"></stop>
                                                             <stop offset="1" style="stop-color:#FF9511"></stop>
                                                          </linearGradient>
                                                          <polygon data-side="center" class="svg-empty-347" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 212.9,181.1 213.9,181 306.5,241 " style="fill: transparent; stroke: black;"></polygon>
                                                          <polygon data-side="left" class="svg-active-347" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 " style="stroke-opacity: 0;"></polygon>
                                                          <polygon data-side="right" class="svg-active-347" points="364,55.7 255.5,46.8 214,-59 213.9,181 306.5,241 281.1,129.8 " style="stroke-opacity: 0;"></polygon>
                                                       </svg>
                                                    </div>
                                                @endfor
                                                ({{intval($userRating->rating)}}/5)
                                                <br/>
                                                <span style="color:black;">{{$userRating->comment}}</span><br/><br/>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="notAuthorized" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <p class="text-bold text-dark">Messages can only be sent if you and this user are both connected with each other.</p>
                    <a href="javascript:void(0);" onclick="location.reload();" class="btn-sm btn btn-success px-4 py-1">Got it, thanks.</a>
                </div>
            </div>         
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalForMessaging" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="w-100 text-center">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="">
                    <form action="javascript:void(0);" method="post" class="userMessage">
                        @csrf
                        <input type="hidden" value="{{$userData['id']}}" name="receiverId">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1" class="text-dark  mb-0">Message</label>
                            <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>                    
                        <div class="text-center">
                            <button type="submit" class="btn btn-success  w-50 text-center p-2">Submit</button>
                        </div>    
                    </form>
                </div>
            </div>         
        </div>
    </div>
</div>
<!-- START MODAL -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header">
                <div class="ml-auto">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center"> 
                @if($userConnected <= 1)
                    <div>
                        <div class="py-4">
                            <p class="text-bold text-dark">Reviews can only be submitted if you and this user are both connected with each other.</p>
                            <a href="javascript:void(0);" onclick="location.reload();" class="btn-sm btn btn-success px-4 py-1">Got it, thanks.</a>
                        </div>
                    </div>
                @else
                    <div class="py-4 confirmMessageAfterSubmit d-none">
                        <h4 class="text-bold">Thank you for your feedback.</h4>
                        <a href="javascript:void(0);" onclick="location.reload();" class="btn-sm btn btn-success px-4 py-1">Ok</a>
                    </div>
                    <table style="display: inline-table;width: 100%" class="userRatintView">                   
                        <tr>
                            <td>
                                <span class="my-rating"></span>
                                <div class="live-rating d-none"></div>
                                <input type="hidden" value="{{(isset($userRating['rating'])?$userRating['rating']:'')}}"  id="ratingValue"> 
                                <input type="hidden" value="{{$userData['id']}}"  id="toUserId"> 
                                <input type="hidden" value="{{(isset($userRating['comment'])?$userRating['comment']:'')}}"  id="toRowId"> 
                                <textarea rows="4" name="comment" value="" class="form-control form-control-alternative userReviewComment mt-2" placeholder="" style="font-size:14px;">{{(isset($userRating['comment'])?$userRating['comment']:'')}}</textarea>
                            </td>                        
                        </tr> 
                        <tr>
                            <td> <a href="javascript:void(0);" class="submitUserReview btn-sm btn btn-success my-3 py-1 w-100">Submit</a></td>
                        </tr>
                    </table>
                @endif
            </div>         
        </div>
    </div>
</div>
<!--END MODAL-->
@endsection
@push('scripts')
<script>
    if (<?php echo isset($userRating['rating']) ? $userRating['rating'] : 0; ?> == 0) {
        $(".my-rating").starRating({
            useFullStars: true,
            totalStars: 5,
            starSize: 30,
            initialRating: 0,
            ratedColor: '#52cb7c',
            disableAfterRate: false,
            onHover: function (currentIndex, currentRating, $el) {
                $('.live-rating').text(currentIndex);
            },
            onLeave: function (currentIndex, currentRating, $el) {
                $('#ratingValue').val(currentRating);
            }
        });
    } else {
        $(".my-rating").starRating({
            useFullStars: true,
            totalStars: 5,
            starSize: 30,
            initialRating: <?php echo isset($userRating['rating']) ? $userRating['rating'] : 0; ?>,
            ratedColor: '#52cb7c',
            disableAfterRate: false,
            onHover: function (currentIndex, currentRating, $el) {
                $('.live-rating').text(currentIndex);
            },
            onLeave: function (currentIndex, currentRating, $el) {
                $('#ratingValue').val(currentRating);
            }
        });
    }
    $(document).on("click", ".submitUserReview", function () {
        var user_rating = $('#ratingValue').val();
        var toUserId = $('#toUserId').val();
        var userReviewComment = $('.userReviewComment').val().trim();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/userRating",
            data: {user_rating: user_rating, toUserId: toUserId, userReviewComment: userReviewComment},
            dataType: 'json',
            context: this,
            success: function (data) {
                if (data.status == 'success') {
                    $('.userRatintView').hide();
                    $('.confirmMessageAfterSubmit').removeClass('d-none');
                }
            }
        });
    });</script>
<style> 
    #main-user-image {
        width:150px;height: 150px;
    }

    table {
        display: inline-block;
    }
    .golden {
        color: #ee0;
        background-color: #444;
    }
    .big-red {
        color: #f11;
        font-size: 50px;
    }
    .rating:not([disabled]) .star:hover::after, .rating .star.active::after{
        height: 1.5em!important;
    }
    @media screen and (max-width:600px){
    
    #main-user-image {
        width:100px;height: 100px;
    }
        .submitReview{
            display: none
        }
        .submitReviewForMobile{
            margin-top: 10px;
            display: block!important;
        }

        .serviceIndustry{
            text-align: center;
        }
    }
</style>
<style>
    .sub-heading{
        color: #ff7c00;
        font-size: 17px;
        font-family: inherit;
    }
    .userProvides li{
        color: #333;
        font-size: 13px;
    }
    .userProvides .main-heading{
        text-align: center
    }
</style>
<script>
    $(document).on("click", ".submitReview", function () {
        $('#reviewModal').modal('show');
    });
    $(document).on("submit", ".userMessage", function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/userMessage",
            data: $('.userMessage').serialize(),
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    Swal.fire(
                            'Success!',
                            'Message has been succesfully sent to the user.'
                            )
                    $('#modalForMessaging').modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.notAuthorizedForMessaging', function () {
        $('#notAuthorized').modal('show');
    });

    $(document).on('click', '.modalForMessaging', function () {
        $('#exampleFormControlTextarea1').val('');
        $('#modalForMessaging').modal('show');
    });

    $(document).on('click', '.connectUser', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/userReview",
            data: {data: 'accept', to_user_id: <?php echo $userData['id']; ?>},
            dataType: 'json', context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    location.reload();
                }
            }
        });
    });
</script>
@endpush
