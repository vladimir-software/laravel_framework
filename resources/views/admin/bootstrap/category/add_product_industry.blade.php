@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">New Industry</h4>           
            <form method="post" action="{{route('category.store-product-industry1')}}" class="forms-sample serviceCategory">
                @csrf
                <div class="form-group">
                    <input type="text" name="industry" class="form-control input-sm" placeholder="industry  name"  required="">
                </div>
                <button type="submit" class="btn btn-success mr-2">Add</button>
            </form>
        </div>
    </div>
</div>
@endsection