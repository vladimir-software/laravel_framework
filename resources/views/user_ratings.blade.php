@extends('layouts.elements.app')
@section('content')
<div class="position-relative profilePages">
    <!--<div style="height:100px;"></div>-->
    <div class="container mt--7">
        <div class="row my-5">
            <div class="col-sm-12"><h2 class="text-center">Ratings</h2></div>
            @if($userRating->isNotEmpty())
            @foreach($userRating as $data)
            @php $userData = App\Models\Users\User::select('id','fullname','profile_pic')->where(['id'=>$data->user_id])->first();  @endphp
            <div class="col-md-4  mb-5 mb-lg-0">
                <div class="card card-profile mt-4"> 
                    <div class="card-body  pt-4 userRating">
                        <div class="px-4 text-center">
                            <a href="{{route('user-profile',$userData->id)}}" style="color: #ff7c00!important;">
                                <img src="{{($userData->profile_pic != '')?asset($userData->profile_pic):asset('asset/noimage_person.png')}}" class="rounded-circle img-center img-fluid shadow shadow-lg--hover" style="width: 200px;">
                            </a>
                            <div class="pt-4 ">
                                <h5 class="title">
                                    <span class="d-block mb-1">
                                        <a href="{{route('user-profile',$userData->id)}}" style="color: #ff7c00!important;">{{(isset($userData->fullname)?$userData->fullname:'Unknown')}}</a>
                                    </span>
                                    <small class="h6 text-muted">  
                                        <p class="small" style="color: #333;">
                                            {{(isset($data->comment)?$data->comment:'')}}
                                        </p></small>
                                </h5>
                                <div class="mt-3">
                                    @for ($x = 1; $x <= $data->rating; $x++) 
                                    <i class="fas fa-star StarColorYellow"></i>
                                    @endfor
                                    @php $val1 = 5 - $data->rating; @endphp
                                    @for ($j = 1; $j <= $val1; $j++)
                                    <i class="far fa-star"></i>
                                    @endfor
                                </div>
                                <p style="color: #333;font-size: 12px;">{{$data->created_at->diffForHumans()}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .userRating table th{
        color: #333;
    }
    .StarColorYellow{
        color: #ff7c00!important;
    }
</style>
@endpush