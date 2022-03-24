@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body"> 
            <h4 class="card-title">User Details</h4>
            <hr>
            <div class="" style="display: flex;">
                <h5>Name: </h5>
                <p>{{$user_data['fullname']}}</p>
            </div>
            <div class="" style="display: flex;">
                <h5>Email: </h5>
                <p>{{$user_data['email']}}</p>
            </div>
            <div class="" style="display: flex;">
                <h5>Contact: </h5>
                <p>{{$user_data['mobile_number']}}</p>
            </div> 
            <hr>
            <div class="d-flex my-5">
                <h4 class="card-title">User Survey</h4>
                <div class="ml-auto">                   
                    @if(isset($user_data['approval']) && $user_data['approval'] == 1)
                    <a href="javascript:void" class="btn btn-default notika-btn-info waves-effect text-success" style="font-size: 16px;font-weight: 700;font-family: serif;">Approved</a>
                    <a href="{{route('users.userRejected1',$user_data->token)}}"  class="btn btn-outline-danger" >Reject</a>
                    @elseif(isset($user_data['reject']) && $user_data['reject'] == 1)
                    <a href="{{route('users.userApproval1',$user_data->token)}}" class="btn btn-outline-success">Approve</a>
                    <a href="javascript:void" class="btn btn-default notika-btn-info waves-effect text-danger" style="font-size: 16px;font-weight: 700;font-family: serif;">Rejected</a>
                    @else
                    <a href="{{route('users.userApproval1',$user_data->token)}}" class="btn btn-outline-success">Approve</a>
                    <a href="{{route('users.userRejected1',$user_data->token)}}"  class="btn btn-outline-danger" >Reject</a>
                    @endif
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Survey</th>                                   
                            <th>Status</th>                                  
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($userSurvey as $key=> $survey)

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_2')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Tell us about your business.</td>
                            <td>
                                @if(isset($survey['answer']) && $survey['answer'] != "")
                                <ul style="list-style: unset;">
                                    @foreach($survey['answer'] as $dd)
                                    <li class="text-capitalize">{{$dd}}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                            <td>@if($survey['skip'] == 0)Answered @else Skipped @endif</td>
                        </tr>
                        @endif

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_3')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>What is your primary goal?</td>
                            <td>
                                @if(isset($survey['answer']) && $survey['answer'] != "")
                                <ul style="list-style: unset;">
                                    @foreach($survey['answer'] as $dd)
                                    <li>{{$dd}}</li>
                                    @endforeach
                                </ul>
                                @endif                             

                            </td>
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'pageForObtainBusiness')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Tell us about services you're interested in obtaining.</td>
                            <td>
                                <ol style="list-style: unset;">
                                    @if(isset($service_cat1) && $service_cat1 != "")
                                    @foreach($service_cat1 as $key=> $val) 
                                    <li>{{$val['name']}} > {{isset($is_exist[$key]['sub_cat_name'])?$is_exist[$key]['sub_cat_name']:''}} </li>  
                                    @endforeach
                                    @endif
                                </ol>
                            </td>                            
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif


                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_4')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Tell us about your super cool service.</td>
                            <td>
                                <ul>
                                    @if(!empty($service_cat))
                                    <li>
                                        Category:
                                        <ol type="1">
                                            @foreach($service_cat as $key=> $val)
                                            <li>{{$val['name']}} {{isset($in_exist[$key]['sub_cat_name']) ? '> '.$in_exist[$key]['sub_cat_name'] : ''}} </li>  
                                            @endforeach
                                        </ol>                                  
                                    </li>
                                    @endif

                                    @if(!empty($coolServeiceIndustry)) 
                                    <li>                                        
                                        Industry:
                                        <ol type="1">
                                            @foreach($coolServeiceIndustry as $data)
                                            <li>
                                                {{$data['name']}}
                                            </li>
                                            @endforeach
                                        </ol>                                      
                                    </li>
                                    @endif
                                    @if(!empty($survey['description']['answer']))
                                    <li>{{isset($survey['description']['question'])?'Q:'.$survey['description']['question']:""}}<br>
                                        {{isset($survey['description']['answer'])?'Ans: '.$survey['description']['answer']:""}}
                                    </li>   
                                    @endif
                                </ul>
                            </td>
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_5')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Tell us about your awesome product.</td>
                            <td>
                                @if(isset($survey['answer']) && $survey['answer'] != "")
                                <ul>
                                    <li>  
                                        Type of Products:
                                        @if(isset($productCategory) && $productCategory != "")
                                        <ol type="1">
                                            @foreach($productCategory as $data)
                                            <li> {{$data['name']}}</li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    <li> 
                                        Industry:                                         
                                        @if(isset($productIndustry) && $productIndustry != "")  
                                        <ol type="1">
                                            @foreach($productIndustry as $data)
                                            <li>
                                                {{$data['name']}}
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                    <li> Q: {{isset($survey['answer']['question'])?$survey['answer']['question']:""}}<br>
                                        Ans: {{isset($survey['answer']['answer'])?$survey['answer']['answer']:""}}</li>
                                </ul>
                                @endif
                            </td>
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_6')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Where is your business located?</td>
                            <td>
                                @if(isset($survey['answer']) && $survey['answer'] != "")
                                <ul>
                                    <li><b>Location:</b> {{isset($survey['answer']['answer'])?$survey['answer']['answer']:""}}</li>
                                    <li><b>Lat/Lng:</b> {{isset($survey['answer']['lat_lng'])?$survey['answer']['lat_lng']:""}}</li>
                                </ul>
                                @endif
                            </td>
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif

                        @if(isset($survey['page_name']) && $survey['page_name'] == 'page_7')
                        <tr>
                            <td>{{++$key}}</td>
                            <td>Please fill out the following questions to submit your application.</td>
                            <td>
                                <table class="table table-sc-ex">
                                    <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($survey['answer']) && $survey['answer'] != "")
                                        @foreach($survey['answer']['question'] as $key=> $ddd)
                                        <tr>
                                            <td>{{$ddd}}</td>
                                            <td>{{isset($survey['answer']['answer'][$key])?$survey['answer']['answer'][$key]:""}}</td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </td>
                            <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                        </tr>
                        @endif
                        @endforeach      
                    </tbody>     
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    thead tr th{
        font-weight: 900 !important;
    }
    h5{
        margin-right: 1rem;
    }
    .card{
        width: 400px;
        /*/box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12);*/
        padding: 1rem;
    }


</style>
@endsection
