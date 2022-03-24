@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Main Categories</h4>                                
                <a href="{{route('category.add-product-category1')}}" class="btn btn-primary  btn-xs ml-auto">
                    <i class="fa fa-plus"></i>  Add                          
                </a>               
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                        </tr>
                    </thead>
                    <tbody class="appendCategory" id="cat">
                        @foreach($provideCategory as $cat)
                        <tr>
                            <td>{{$cat['id']}}</td>
                            <td>{{$cat['name']}}</td>                                           
                        </tr>    
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCategoryModal" role="dialog" style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Add Category</h2>
                    <div class="form-group">
                        <div class="nk-int-st">
                            <input type="text" class="form-control input-sm categoryName"  placeholder="Name">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect submitCategory" data-dismiss="modal">Submit</button>
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<style>
    h4{
        margin-right: 1rem;
    }
    .card{
        width: 400px;
        /*box-shadow: 0 2px 5px rgba(0,0,0,.16), 0 2px 10px rgba(0,0,0,.12);*/
        padding: 1rem;
    }
</style>
<script src="{{asset('js/jquery-1.12.4.min.js')}}"></script>
<script>
$(document).on('click', '.addCategory', function () {
    $(".categoryName").val('');
    $("#addCategoryModal").modal('show');
});
//submitCategory
$(document).on('click', '.submitCategory', function () {
    var catName = $(this).parent().siblings().find('input[type="text"]').val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/admin/add-category",
        data: {cat_name: catName},
        dataType: 'json',
        context: this,
        success: function (data)
        {
            if (data.message == 'success') {
                $(".appendCategory").append('<tr><td>' + data.category.id + '</td><td>' + data.category.name + '</td></tr>');
            } else if (data.status == 'failed') {
                toastr["error"](data.message);
            }
        }
    });
});
</script>

@endsection