@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex mb-5">
                <h4>Service Category</h4>                                
                <a href="{{route('category.add-service-category1')}}" class="btn btn-success  btn-sm ml-auto" style="font-size: 13px;">
                    <i class="fa fa-plus"></i>  Add                          
                </a>               
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Sub Categories</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category as $key=> $cat)  
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{$cat['name']}}</td>  
                            <td>
                                <ul style="overflow-y: scroll;height: 75px;">
                                    @foreach($cat->serviceSubCategory as $sub_cat)
                                    <li>{{$sub_cat['name']}}</li>
                                    @endforeach
                                </ul>                                              
                            </td>
                            <td>
                                <a href="{{route('category.edit-service-category',$cat['id'])}}">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="{{route('deleteServiceCategory',$cat['id'])}}">
                                    <i class="fas fa-trash text-danger ml-2"></i>
                                </a>
                            </td>
                        </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

