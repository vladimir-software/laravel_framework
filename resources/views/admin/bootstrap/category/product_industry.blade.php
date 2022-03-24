@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Industry</h4>                                
                <a href="{{route('category.add-product-industry1')}}" class="btn btn-primary  btn-xs ml-auto">
                    <i class="fa fa-plus"></i>  Add                          
                </a>               
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">                 
                    <thead>
                        <tr>                           
                            <th>Name</th>                                          
                            <th>Action</th>     
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productIndustry as $cat)
                        <tr>                           
                            <td>
                                <input type="text"  value="{{$cat['name']}}" class="form-control input-sm"  required="" readonly=""></td>
                            <td>
                                <a href="javascript:void(0);" class="editProductIndustry">
                                  <i class="far fa-edit"></i>
                                </a>
                                <a href="javascript:void(0);" class=" d-none saveIndustry" rel="{{$cat['id']}}">
                                    <i class="globalIconsStyle saveIcon fas fa-save"></i>
                                </a>
                                <a href="{{route('deleteProductIndustry',$cat['id'])}}">
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
    $(document).on('click', '.editProductIndustry', function () {
        $(this).parent().siblings('td').find("input").removeAttr('readonly');
        $(this).addClass('d-none');
        $(this).siblings('.saveIndustry').removeClass('d-none');
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
    });

    $(document).on('click', '.saveIndustry', function () {
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/updateIndustry",
            data: {id: id, product_industry: subCatData},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(this).addClass('d-none');
                    $(this).siblings('.editProductIndustry').removeClass('d-none');
                    $(this).parent().siblings('td').find("input").prop('readonly', 'readonly');
                    $(this).parent().siblings('td').find("input").val(data.ProductIndustry.name);

                } else {

                }
            }
        });
    });
</script>
@endpush