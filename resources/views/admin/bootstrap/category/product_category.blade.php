@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Product Category</h4>                                
                <a href="{{route('category.add-product-category1')}}" class="btn btn-success  btn-sm ml-auto" style="font-size: 13px;">
                    <i class="fa fa-plus"></i>  Add                          
                </a>               
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">                 
                    <thead>
                        <tr>                          
                            <th>Category Name</th>              
                            <th>Action</th>              
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productCat as $cat)
                        <tr>                          
                            <td>
                                <input type="text"  value="{{$cat['name']}}" class="form-control input-sm"  required="" readonly="">
                            </td>  
                            <td>
                                <a href="javascript:void(0);" class="editProductCategory">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);" class=" d-none saveCategory" rel="{{$cat['id']}}">
                                    <i class="globalIconsStyle saveIcon fas fa-save"></i>
                                </a>
                                <a href="{{route('deleteProductCat',$cat['id'])}}">
                                    <i class="removeIcon fas fa-trash text-danger ml-2"></i>
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
@push('scripts')
<script>
    $(document).on('click', '.editProductCategory', function () {

        $(this).parent().siblings('td').find("input").removeAttr('readonly');
        $(this).addClass('d-none');
        $(this).siblings('.saveCategory').removeClass('d-none');
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
    });

    $(document).on('click', '.saveCategory', function () {
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/updateProductCategory",
            data: {id: id, product_cat: subCatData},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(this).addClass('d-none');
                    $(this).siblings('.editProductCategory').removeClass('d-none');
                    $(this).parent().siblings('td').find("input").prop('readonly', 'readonly');
                    $(this).parent().siblings('td').find("input").val(data.ProductCat.name);

                } else {

                }
            }
        });
    });
</script>
@endpush