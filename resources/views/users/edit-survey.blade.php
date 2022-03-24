@extends('layouts.elements.app')
@section('content')
<section class=" bg-light">
    <div class="container bg-white my-4">     
        <div class="row">
            <div class="card"  style="box-shadow:none!important ">
                <div class="card-body">
                    <div class="col-12 my-4"> 
                        <div class="d-flex ">
                            <h3><b>User Survey</b></h3>                    
                            <div class="ml-auto">
                                <a href="{{route('edit_survey.survey-1')}}" class="btn btn-sm btn-success text-white px-4 py-2 rounded">Edit</a>                  
                            </div>
                        </div>
                    </div>
                    @if(!empty($userSurvey))
                    <div class="table-responsive"></div>
                    <table class="table table-bordered  table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Question</th>
                                <th scope="col" class="pl-4">Survey</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($userSurvey as $key=> $survey)


                            @if(isset($survey['page_name']) && $survey['page_name'] == 'page_2')
                            <tr>
                                <td>{{++$key}}</td>
                                <td>Business</td>
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
                                <td>Goals</td>
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
                                <td>Obtaining Services</td>
                                <td>
                                    <ol style="list-style: unset;"> 

                                        @if(isset($service_cat1) && $service_cat1 != "")

                                        @foreach($service_cat1 as $key=> $val) 
                                        <li>{{$val['name']}} > {{isset($service_sub_cat2[$key]['name'])?$service_sub_cat2[$key]['name']:''}} </li>  
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
                                <td>Services</td>
                                <td>
                                    <ul>
                                        <li>
                                            @if(isset($service_cat) && $service_cat != "")
                                            Category:
                                            <ol type="1">
                                                @foreach($service_cat as $key=> $val)
                                                <li>{{$val['cat_name']}} {{isset($val['sub_cat_name']) ? '> '.$val['sub_cat_name'] : ''}} </li>  
                                                @endforeach
                                            </ol>                                   
                                            @endif
                                        </li>
                                        <li>                                          
                                            Industry:
                                            @if(isset($coolServeiceIndustry) && $coolServeiceIndustry != "")  
                                            <ol type="1">
                                                @foreach($coolServeiceIndustry as $data)
                                                <li>
                                                    {{$data['name']}}
                                                </li>
                                                @endforeach
                                            </ol>
                                            @endif
                                        </li>



                                        <li>{{isset($survey['description']['question'])?'Q:'.$survey['description']['question']:""}}<br>
                                            {{isset($survey['description']['answer'])?'Ans: '.$survey['description']['answer']:""}}
                                        </li>                                        
                                    </ul>                                 
                                </td>
                                <td>@if($survey['skip'] == 0) Answered @else Skipped @endif</td>
                            </tr>
                            @endif

                            @if(isset($survey['page_name']) && $survey['page_name'] == 'page_5')
                            <tr>
                                <td>{{++$key}}</td>
                                <td>Products</td>
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
                                <td>location</td>
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

                            @endforeach                        

                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <h4 class="text-danger">Survey not started yet.</h4>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@push('styles')
<style>
    thead tr th{
        font-weight: 900 !important;

    }
    thead tr {
        border-bottom: 1px solid #ccc !important;
    }
    thead tr th,td{
        color: #000;
        text-align: left;
        font-size: 14px;
        text-transform: uppercase;
    }
    h5{
        margin-right: 1rem;
    }
    .card{
        border: none;

    }
</style>

@endpush