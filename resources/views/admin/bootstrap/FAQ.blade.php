@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">         
            <div class="d-flex mb-5">
                <h4 class="card-title">Frequently Asked Questions</h4>  
                <div class="ml-auto">
                    <a href="{{route('bootstrap.add_FAQs')}}" class="btn btn-primary notika-btn-info waves-effect">
                        <i class="fas fa-plus"></i>Add</a>                  
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>                                   
                            <th>Answer</th>                                  
                            <th>Action</th>                                  
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($faq as $data)
                        <tr>
                            <td>{{$data['id']}}</td>
                            <td>{{$data['question']}}</td>
                            <td>{{$data['answer']}}</td>  
                            <td class="d-flex">
                                <a href="{{route('bootstrap.edit_FAQs',$data['id'])}}" class="pr-2"><i class="far fa-edit"></i></a>
                                <a class="deleteFaq" href="javascript:void(0);" rel="{{$data['id']}}"><i class="fas fa-trash text-danger ml-2"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<style>
    thead tr th{
        font-weight: 900 !important;
    }
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
@push('scripts')
<script>
    $(document).on('click', '.deleteFaq', function () {
        var id = $(this).attr('rel');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '/admin/deleteFAQ/' + id + '';

            }
        })
    });
</script>

@endpush