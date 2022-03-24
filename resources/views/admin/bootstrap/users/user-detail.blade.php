@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-md-6 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">User Details</h4>
                    <hr>
                    <div class="" style="display: flex;">
                        <h5>Name: </h5>
                        <p>{{$users['fullname']}}</p>
                    </div>
                    <div class="" style="display: flex;">
                        <h5>Email: </h5>
                        <p>{{$users['email']}}</p>
                    </div>
                    <div class="" style="display: flex;">
                        <h5>Contact: </h5>
                        <p>{{$users['mobile_number']}}</p>
                    </div>
                </div>
            </div>
        </div>      
    </div>
</div>
<style>
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