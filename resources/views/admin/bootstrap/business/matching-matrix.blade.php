@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-inline-flex w-100">
                    <h4 class="card-title">Collaboration Matching Matrix</h4>
                    <div class="ml-auto ">
                        <a href="{{route('admin.bootstrap.business.manage-business')}}" class="btn btn-success btn-sm" style="font-size:13px;"><i class="fas fa-plus"></i> Add</a>
                    </div>
                </div>
                <div class="row">                         
                    <div class="col-md-12">
                        <div class="grid-margin stretch-card">
                            <div class="card">              
                                <div class="card-body"> 
                                    @if(!empty($collaborationCategory))                                         
                                    <ul>
                                        @foreach($collaborationCategory as $key => $data)
                                        <li>
                                            <ol>
                                                <li>
                                                    <i class="fas fa-check-double"></i> 
                                                        {{isset($data['name'])?'> '.$data['name']:''}} {{isset($collaborationSubCategory[$key]['name'])?'> '.$collaborationSubCategory[$key]['name']:''}}
                                                        {{isset($collaborationProduct[$key]['name'])?'> '.$collaborationProduct[$key]['name']:''}}
                                                </li>
                                                <li>
                                                    <i class="fas fa-check-double"></i> 
                                                    {{isset($collaborationMatchCategory[$key]['name'])?'> '.$collaborationMatchCategory[$key]['name']:''}}
                                                    {{isset($collaborationMatchSubCategory[$key]['name'])?'> '.$collaborationMatchSubCategory[$key]['name']:''}}
                                                    
                                                    {{isset($collaborationMatchProduct[$key]['name'])?'> '.$collaborationMatchProduct[$key]['name']:''}}
                                                </li>
                                            </ol>
                                            <a href="javascript:void(0)"  rel="{{$collaborationId[$key]}}" class="deleteService"><i class="fas fa-trash text-danger"></i></a>
                                        </li>
                                        <hr>
                                        @endforeach
                                    </ul>                                          
                                    @endif
                                </div>
                                <div class="ml-auto">
                                    <span>{{$matrixCollaboration->links()}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    li{
        list-style-type: none;
    }
    .fa-check-double{
        position: relative;
        top: 1px;
        right:1px;
    }
    .deleteProduct, .deleteService{
        float: right;       
    }
    .deleteService{
        position: relative;
        top: -20px;
    }
    .text-danger{
        color:red!important;
    }
    .tabIcons{
        color:#ff7c00;
        display: none;
    }

    .tablist li{
        width:33%;
        border-right: 1px solid #ccc;
        letter-spacing: 1px;

    }
    .tablist li .nav-link{
        text-align: center!important;

    }
</style>
<script>
    $(document).on('click', '.deleteService', function (e) {
        var serviceId = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure you want to delete this item?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/admin/deleteServices",
                    data: {serviceId: serviceId},
                    dataType: 'json',
                    context: this,
                    success: function (data)
                    {
                        if (data.status == 'success') {
                            $(this).parent('li').next('hr').remove();
                            $(this).parent('li').remove();
                            Swal.fire(
                                    'Deleted!',
                                    'Item has been deleted successfully.',
                                    'success'
                                    )
                        } else {
                            Swal.fire(
                                    'Error!',
                                    '' + data.message + ''
                                    )
                        }
                    }
                });
            }
        })
        return false;
    });

    $(document).on('click', '.deleteProduct', function (e) {
        var productId = $(this).attr('rel');

        Swal.fire({
            title: 'Are you sure you want to delete this item?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/admin/deleteProduct",
                    data: {productId: productId},
                    dataType: 'json',
                    context: this,
                    success: function (data)
                    {
                        if (data.status == 'success') {
                            $(this).parent('li').next('hr').remove();
                            $(this).parent('li').remove();
                            Swal.fire(
                                    'Deleted!',
                                    'Item has been deleted successfully.',
                                    'success'
                                    )
                        } else {
                            Swal.fire(
                                    'Error!',
                                    '' + data.message + ''
                                    )
                        }
                    }
                });
            }
        })
        return false;
    });


</script>
@endpush
