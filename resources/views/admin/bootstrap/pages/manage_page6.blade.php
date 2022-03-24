@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Survey-6</h4>                                
                <!--                <a href="" class="btn btn-primary  btn-xs ml-auto">
                                    <i class="fa fa-plus"></i>  Add                          
                                </a>              -->
            </div>
            <form method="post" action="{{route('updateSurvey6')}}">
                @csrf              
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">                
                        <tbody>                            
                            <tr> 
                                <td> 
                                    <h4>Location Map API key</h4>
                                    <input type="text" value="{{$list['content']}}"  name="content" class="form-control input-sm" required="" readonly="">
                                </td>  
                                <td>   

                                    <a href="javascript:void(0);" class="edit">
                                       <i class="far fa-edit"></i>
                                    </a>                                
                                    <!--                                    <a href="javascript:void(0);">
                                                                            <i class="removeIcon removeData globalIconsStyle mdi mdi-close-circle-outline"></i>
                                                                        </a>-->
                                </td>  
                            </tr>                        
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
