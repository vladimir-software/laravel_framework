@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Welcome</h4>                              
            </div>
            <form method="post" action="{{route('updateWelcome')}}">
                @csrf
                <input type="hidden" value="{{$list['page_name']}}" name="id" id="welcomePage">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered">                
                        <tbody> 
                            <tr>
                                <td>
                                    <h4>Image</h4> 
                                    <div class="img">
                                        <img src="{{asset($list['image'])}}" style="width: 200px;height:90px;" id="welImage"> 
                                        <div class="file btn btn-lg float-right" style="background: #0cb7f5;color: #fff;">
                                            Change Photo
                                            <input type="file" name="welcom_image" id="welcomImage">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @php $json = json_decode($list->content, true);  @endphp   
                            <tr>                        
                                <td>
                                    <h4>Heading</h4>
                                    <input type="text" value="{{$json['heading'] }}"  name="heading" class="form-control input-sm" required="" readonly="">
                                </td>  
                                <td>                                
                                    <a href="javascript:void(0);" class="edit">
                                        <i class="mdi globalIconsStyle mdi-circle-edit-outline"></i>
                                    </a>                                
                                    <!--                                    <a href="javascript:void(0);">
                                                                            <i class="removeIcon removeData globalIconsStyle mdi mdi-close-circle-outline"></i>
                                                                        </a>-->
                                </td>  
                            </tr>
                            @if(isset($json['paragraph']) && $json['paragraph'] != '' )
                            <tr>                          
                                <td>
                                    <h4>Paragraph</h4>                                
                                    <input type="text" value="{{$json['paragraph'] }}" name="paragraph" class="form-control input-sm" required="" readonly="">                                    
                                </td>  
                                <td>                                
                                    <a href="javascript:void(0);" class="edit">
                                        <i class="mdi globalIconsStyle mdi-circle-edit-outline"></i>
                                    </a>                                
                                    <!--                                    <a href="javascript:void(0);">
                                                                            <i class="removeIcon removeData globalIconsStyle mdi mdi-close-circle-outline"></i>
                                                                        </a>-->
                                </td>  
                            </tr> 
                            @endif

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
<style>
    .-img .file {
        position: relative;
        overflow: hidden;
        margin-top: -20%;
        width: 60%;
        border: none;
        border-radius: 0;
        font-size: 15px;
        background: #212529b8;
    }
    .img .file input {
        position: absolute;
        opacity: 0;
        right: 73px;
    }

</style>
<script>
    $(document).on('click', '.edit', function () {
        $(this).parent().siblings('td').find("input").removeAttr('readonly').focus();
        $('.save').removeClass('d-none');
    });

    $(document).on('click', '.removeData', function () {
        $('.save').removeClass('d-none');
        $(this).parents('tr').remove();
    });

    $(document).on("change", "#welcomImage", function () {
        var file_data = $("#welcomImage").prop("files")[0];
        var id = $("#welcomePage").val();
        //alert(id);return false;
        var myFormData = new FormData();
        myFormData.append('welcom_image', file_data);
        myFormData.append('id', id);
        var myFile = $(this).prop('files');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'updateWelcomeImage',
            type: 'POST',
            processData: false, // important
            contentType: false, // important
            dataType: 'json',
            data: myFormData,
            success: function (data)
            {
                if (data.status == 'success') {
                    $('#welImage').attr('src', data.welcome.image);
                } else {

                }
                ;
            }
        });
    });
    //
</script>
@endpush