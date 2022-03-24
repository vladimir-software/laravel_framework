@extends('layouts.elements.app')
@section('content')

<div class="container my-5" id="connection">
    <div class="row mb-4">
        <div class="col-6 col-sm-3 order-2 order-md-1"> 
            <form method="post" action="javascript:void(0);" class="d-flex align-items-center" id="MatchedPendingFilter">               
                <div class="form-check mb-2 pl-0 mr-2" style="display: flex;flex-direction: row;">                           
                    <input class="mr-1 surveyCheckBox filterMatchingPending" name="pending"  type="checkbox"  value="pending" id="defaultCheck1" style="margin-top:4px!important;" checked="">
                    <label class="form-check-label suveyLabel  text-dark mb-2" for="defaultCheck1">Pending</label>
                </div>
                <div class="form-check mb-2 pl-0 " style="display: flex;flex-direction: row;margin-top:2px;">                           
                    <input class="mr-1 surveyCheckBox filterMatchingPending" name="matched" type="checkbox"  value="matched" id="defaultCheck2" style="margin-top:4px!important;" checked="">
                    <label class="form-check-label suveyLabel text-dark mb-2" for="defaultCheck2">Matched</label>
                </div>
            </form>
        </div>
        <div class="col-sm-6 order-1 order-md-2">  
            <div class="text-center mx-auto">
                <h2 class="">Collaboration Matches</h2>
            </div>
        </div>
        <div class="col-6 col-sm-3 text-right order-3">
            <a class="btn btn-primary dropdown-toggle count-indicator setName" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" style="color:#ff7c00" aria-expanded="false">
                <span>All</span>
            </a>
            <div class="dropdown-menu bg-white dropdown-menu-right navbar-dropdown preview-list mainNavbarDropdownMenu" aria-labelledby="messageDropdown" style="border: none;">
                @if(count($dropdown) >=1)
                @php $i=1;@endphp
                <a href="javascript:void(0)" class="btn btn-outline-success dropdown-item filterByDropdown" style="font-size:14px">View All</a>
                @foreach($dropdown as $key=>  $data) 
                <a href="#" class="btn btn-outline-success dropdown-item small filterByDropdown" rel="{{$key}}" style="font-size:14px"> {{$data}} </a>   
                @endforeach  
                @endif   
            </div>
        </div>
    </div>

    <div class="row" id="findFilteredMatches">
        @if(count($usersForObtainServices) >=1)
        @php $i=1;@endphp
        @foreach($usersForObtainServices as  $data)  
        @php $ids = implode(' ', $data['cat_sub_ids']);  @endphp
        <div class="col-md-3 mb-5 mb-lg-0 d-flex align-items-stretch usersMatchesDetails {{$ids}} @if($data['connection'] > 1) matched @else pending @endif">
            <div class="card card-profile mt-4"> 
                <div class="card-body p-0 userRating d-flex flex-column">
                    @if($data['connection'] > 1)
                    <div class="text-center" style="margin-top:-14px;">                        
                        <button type="button" class="btn btn-sm text-white"  style="border-radius:0px;background:green;font-size:12px;padding: 1px 8px;">Matched</button>
                    </div>
                    @else
                    <div class="text-center" style="margin-top:-14px;">                        
                        <button type="button" class="btn btn-sm text-white"  style="border-radius:0px;background:#000;font-size:12px;padding: 1px 8px;">Pending</button>
                    </div>
                    @endif
                    <div class="text-center py-3">                       
                        <img src="{{$data['profile_pic']}}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 150px;height:150px">
                        <div class="pt-4 ">
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
                            <div>
                                @foreach($data['relation'] as $key=>$c)                       
                                <div> <span style="color:#000">{{$key}}</span>
                                    <div class="owl-carousel-coll owl-carousel">                                      
                                        @foreach($c as $k)
                                        <div class="item" style="margin: 0px 10px;"><span class="badge badge-primary px-3 py-1" style="white-space: pre-wrap;font-size:11px">{{$k}}</span></div>                                                                   
                                        @endforeach  
                                    </div>
                                </div> 
                                @endforeach
                                @foreach($data['type'] as $key1=>$c1)
                                @php $m=$c1.":".$data['category_id'][$key1].",".$data['sub_category_id'][$key1]; @endphp
                                @endforeach                                
                            </div>                          
                        </div>
                    </div>
                    <div class="d-flex px-3 mt-auto mb-1">
                        @if($data['total'] > 0)
                        <a href="javascript:void(0)" cat="{{implode(',',$data['category_id'])}}" subCat="{{implode(',',$data['sub_category_id'])}}" class="small getCategoryId">More like this?</a>
                        @endif
                        <span class="small text-dark ml-auto" >{{($data['timing'])?$data['timing']:""}}</span>
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
    .custom-footer{
        bottom: 0px;
        position: absolute;
        width: 100%;
    }
</style>
<style>
    .surveyCheckBox {
        width: 14px;
        height: 14px;
    }
    .hideFilteredData{
        display:none!important
    }
</style>
<script>
    var owlss = $('.owl-carousel-coll');
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
    $(document).on('click', '.getCategoryId', function () {
        var cat = $(this).attr('cat');
        var subCat = $(this).attr('subCat');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/moreCollaborationMatchesSession",
            data: {cat: cat, subCat: subCat},
            success: function (data)
            {
                window.location.href = '/more-collaboration-matches';
            }
        });
    });

    $(document).on('change', '.filterMatchingPending', function () {
        if ($("#defaultCheck1").prop('checked') == true && $("#defaultCheck2").prop('checked') == true) {
            location.reload();
        }
        if ($("#defaultCheck1").prop('checked') == false) {
            $('#findFilteredMatches').find('.pending').each(function () {
                $(this).addClass('hideFilteredData');
            });
        } else {
            $('#findFilteredMatches').find('.pending').each(function () {
                $(this).removeClass('hideFilteredData');
            });
        }
        if ($("#defaultCheck2").prop('checked') == false) {
            $('#findFilteredMatches').find('.matched').each(function () {
                $(this).addClass('hideFilteredData');
            });
        } else {
            $('#findFilteredMatches').find('.matched').each(function () {
                $(this).removeClass('hideFilteredData');
            });
        }
    });

    $(document).on('click', '.filterByDropdown', function () {
        var name = $(this).text();
        if (name == "View All") {
            location.reload();
        } else {
            $(".setName span").text($(this).text());
            $(".setName span").css('font-size', '12px');
        }
        var value = $(this).attr('rel');
        $('#findFilteredMatches').find('.usersMatchesDetails').each(function () {
            $(this).addClass('hideFilteredData');
        });
        $('#findFilteredMatches').find('.' + value).each(function () {
            $(this).removeClass('hideFilteredData');
        });
    });

</script>
@endpush
