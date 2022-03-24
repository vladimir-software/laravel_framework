@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Survey-2</h4>                                
                <!--                <a href="#" class="btn btn-primary  btn-xs ml-auto">
                                    <i class="fa fa-plus"></i>  Add                          
                                </a>               -->
            </div>
            <form method="post" action="{{route('updateSurvey2')}}">
                @csrf
                <input type="hidden" value="page_2" name="id">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">                
                        <tbody>
                            @foreach($list as $data)
                            <tr> 
                                <td> 
                                    <input type="text" value="{{$data['content']}}"  name="content[]" class="form-control input-sm" required="" readonly="">
                                </td>  
                                <td>                                
<!--                                    <a href="javascript:void(0);" class="edit">
                                        <i class="mdi globalIconsStyle mdi-circle-edit-outline"></i>
                                    </a>                                -->
<!--                                    <a href="javascript:void(0);">
                                        <i class="removeIcon removeData globalIconsStyle mdi mdi-close-circle-outline"></i>
                                    </a>-->
                                </td>  
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="2">
                                    <div  class="mt-4">
                                        <button type="submit" class="btn btn-success mr-2 d-none save">Save</button>
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