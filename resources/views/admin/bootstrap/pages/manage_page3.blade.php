@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Survey-3</h4>                                
                <a href="{{route('pages.add-survey-3')}}" class="btn btn-primary  btn-xs ml-auto">
                    <i class="fa fa-plus"></i>  Add                          
                </a>              
            </div>
            <form method="post" action="{{route('updateSurvey3')}}">
                @csrf
                <input type="hidden" value="page_3" name="id">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">                
                        <tbody>
                            @foreach($list as $data)
                            <tr> 
                                <td> 
                                    <input type="text" value="{{$data['content']}}"  name="content[]" class="form-control input-sm" required="" readonly="">
                                </td>  
                                <td>                                
                                    <a href="javascript:void(0);" class="edit">
                                        <i class="far fa-edit"></i>
                                    </a>                                
                                    <a href="javascript:void(0);" rel="{{$data['id']}}">
                                        <i class="removeIcon removeData fas fa-trash text-danger ml-2"></i>                                        
                                    </a>
                                </td>  
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <div  class="mt-4">
                                        <button type="submit" class="btn btn-success mr-2 d-none save">Save</button>
                                        <a href="javascript:void(0)" class="btn btn-primary d-none save" onclick="location.reload();">Cancel</a>
                                    </div> 

                                </td>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')

<script>
    $(document).on('click', '.edit', function () {
        $(this).parent().siblings('td').find("input").removeAttr('readonly').focus();
        $('.save').removeClass('d-none');
    });

    $(document).on('click', '.removeData', function () {
        $('.save').removeClass('d-none');
        $(this).parents('tr').remove();
    });
</script>
@endpush