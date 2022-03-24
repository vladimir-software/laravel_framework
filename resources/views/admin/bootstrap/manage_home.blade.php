@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="row">
    <div class="col-sm-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body">
                    <div class="d-inline-flex w-100">
                        <h4 class="card-title">Manage Home</h4>                       
                    </div>
                    <div class="form-group">
                        <!--<label for="exampleFormControlSelect1">Large select</label>-->
                        <select name="status" class="form-control form-control-lg manageHome" id="exampleFormControlSelect1">
                            <option disabled='' selected="">--Select--</option>
                            <option value="1" @if(isset($matrix) && $matrix['home_status'] == 1) selected @endif>Yes</option>
                            <option value="0"  @if(isset($matrix) && $matrix['home_status'] == 0) selected @endif>No</option>
                        </select>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<style>
    .flexForm{
        width: 100%;
    }
    @media screen and (min-width:600px){
        .flexForm{
            display: flex;          
        }
    }
</style>

<script>
    $(document).on('change', '.manageHome', function () {
        var val = $(this).val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/saveForManageHome",
            data: {status: val},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $('.service').prop('selected', true);
                    $('.setSubCategory').html('');
                    Swal.fire(
                            'Success!',
                            'Successfully saved.'
                            )
                    $('option').first().prop('selected', true);
                } else {
                    Swal.fire(
                            'Error!',
                            '' + data.message + ''
                            )
                }
            }
        });
    });
</script>



@endpush