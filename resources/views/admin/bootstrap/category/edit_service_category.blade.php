@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Category</h4>           
            <form method="post" action="{{route('updateServiceCategory')}}" class="forms-sample serviceCategory">
                @csrf          
                <div class="form-group mb-5">
                    <input type="hidden" value="{{$category['id']}}" name="category_id" id="serviceCatergoryId">
                    <input type="text" name="category_name" value="{{$category['name']}}" class="form-control input-sm"  required="">
                </div> 
                <div class="mb-5">
                    <div class="d-flex mb-5">
                        <h4 class="card-title">Sub Categories</h4>                              
                        <a href="javascript:void(0);" class=" ml-auto addMoreSubCat" style="text-decoration: underline">
                            <i class="fas fa-plus mr-1" style="font-size: 12px;"></i>add  
                        </a>  

                    </div>
                    <table class="w-100">
                        <tbody class="form-group moreSubCategory">
                            @if(isset($category->serviceSubCategory) && $category->serviceSubCategory != '')
                            @foreach($category->serviceSubCategory as $subCat)
                            <tr>
                                <td>
                                    <input type="text"  value="{{$subCat['name']}}" class="form-control input-sm"  required="" readonly="">
                                </td>
                                <td class="float-right">
                                    <a href="javascript:void(0);" class="small editServiceSubCat">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="small d-none saveSubCat" rel="{{$subCat['id']}}">
                                        <i class="globalIconsStyle saveIcon fas fa-save"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="small deleteSubCat" rel="{{$subCat['id']}}">
                                        <i class="removeIcon fas fa-trash text-danger ml-2"></i>                                        
                                    </a>                                    
                                </td> 
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>

                </div>
                <button type="submit" class="btn btn-success mr-2">Update</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    $(document).on('click', '.editServiceSubCat', function () {
        $(this).parent().siblings('td').find("input").removeAttr('readonly');
        $(this).addClass('d-none');
        $(this).siblings('.saveSubCat').removeClass('d-none');
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
    });

    $(document).on('click', '.saveSubCat', function () {
        var id = $(this).attr('rel');
        var subCatData = $(this).parent().siblings('td').find("input").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/updateServiceSubCategory",
            data: {id: id, sub_cat_data: subCatData},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(this).addClass('d-none');
                    $(this).siblings('.editServiceSubCat').removeClass('d-none');
                    $(this).parent().siblings('td').find("input").prop('readonly', 'readonly');
                    $(this).parent().siblings('td').find("input").val(data.subCat.name);

                } else {

                }
            }
        });
    });
    //deleteSubCat
    $(document).on('click', '.deleteSubCat', function () {
        var id = $(this).attr('rel');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/deleteServiceSubCategory",
            data: {id: id},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(this).parents('tr').remove();
                } else {

                }
            }
        });
    });

    //addMoreSubCat
    $(document).on('click', '.addMoreSubCat', function () {
        var myvar = '<tr>' +
                '      <td>' +
                '         <input type="text"  class="form-control input-sm addFoucs"  required="" placeholder="new sub category">' +
                '      <div class="alert alert-success errorAlert d-none" role="alert">Please fill out the field.</div> </td>' +
                '       <td class="float-right">' +
                '           <a href="javascript:void(0);" class="small saveMoreSubCat">' +
                '                 <i class="globalIconsStyle saveIcon fas fa-save"></i>' +
                '           </a>' +
                '           <a href="javascript:void(0);" class="small deleteAppendSubCat" >' +
                '               <i class="removeIcon globalIconsStyle mdi mdi-close-circle-outline"></i>' +
                '           </a>                                    ' +
                '        </td> ' +
                '     </tr>';


        $(".moreSubCategory").prepend(myvar);
        $('.addFoucs').focus();

    });

    $(document).on('click', '.saveMoreSubCat', function () {
        var value = $(this).parent().siblings('td').find('input').val();
        if (value == '') {
            $(".errorAlert").removeClass('d-none');
            return false;
        }
        var id = $("#serviceCatergoryId").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/addMoreSubCategory",
            data: {value: value, id: id},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    location.reload();
                } else {

                }
            }
        });
    });

    $(document).on('keyup', '.addFoucs', function () {
        $(".errorAlert").addClass('d-none');
    });
    $(document).on('click', '.deleteAppendSubCat', function () {
        $(this).parents('tr').remove();
    });

    //saveMoreSubCat

</script>

@endpush