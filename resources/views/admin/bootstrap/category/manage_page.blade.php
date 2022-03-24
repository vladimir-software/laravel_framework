@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-md-12 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">

        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Basic Survey Questions</h4>
                    <div class="add-items d-flex">
                        <input type="text" class="form-control addMoreQ" placeholder="">
                        <button class="add btn btn-primary font-weight-bold addMoreQ-btn">Add</button>
                    </div>
                    <div class="list-wrapper">
                        <form method="post" action="{{route('save-question1')}}"> 
                            <input type="text" class="form-control input-sm" name="page_name" hidden="" value="{{$name}}">
                            @csrf
                            <ul class="d-flex flex-column-reverse todo-list todo-list-custom appendForm">
                                @if(!$list->isEmpty())
                                @foreach($list as $key=> $data)
                                <li>
                                    <div class="">
                                        <input type="text" name="question[]"  value="{{$data->type}}" hidden="">
                                        <label class="form-check-label"> {{$data->type}}   </label>
                                    </div>                                   
                                    <div class="ml-auto">
                                        <a href="javascript:void(0);" class="edit mr-1">
                                            <i class="mdi globalIconsStyle mdi-circle-edit-outline"></i>
                                        </a>
                                        <a href="javascript:void(0);" class=" d-none save mr-1" rel="{{$data['id']}}">
                                            <i class="globalIconsStyle saveIcon fas fa-save"></i>
                                        </a>
                                        <i class="remove mdi mdi-close-circle-outline"></i> 
                                    </div>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                            <div  class="mt-4 text-right">
                                <button type="submit" class="btn btn-success mr-2">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>       
    </div>
</div>
@endsection

@push('scripts')
<script>

    var todoListItem = $('.appendForm');
    var todoListInput = $('.addMoreQ');
    $('.addMoreQ-btn').on("click", function (event) {
        event.preventDefault();
        var item = $(this).prevAll('.addMoreQ').val();
        if (item)
        {
            var myvar = '<li>' +
                    '  <div class="">' +
                    '     <input type="text" name="question[]"  value="' + item + '"  hidden="">' +
                    '       <label class="form-check-label">  ' + item + '   </label>' +
                    '  </div>' +
                    '  <div class="ml-auto">' +
                    '          <i class="remove mdi mdi-close-circle-outline"></i> ' +
                    '   </div>' +
                    '  </li>';




            todoListItem.append(myvar);
            todoListInput.val("");
        }
    });

    $(document).on('click', '.edit', function () {
        $(this).parent().siblings('div').find("label").addClass('d-none');
        $(this).addClass('d-none');
        $(this).siblings('.save').removeClass('d-none');
        $(this).parent().siblings('div').find("input").removeAttr('hidden').css({width: '100%', border: 'none'}).focus();
    });

    $(document).on('click', '.save', function () {
        var id = $(this).attr('rel');
        var data = $(this).parent().siblings('div').find("input").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/updatePage7",
            data: {id: id, data: data},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(this).addClass('d-none');
                    $(this).siblings('.edit').removeClass('d-none');
                    $(this).parent().siblings('div').find("input").prop('hidden', 'hidden');
                    $(this).parent().siblings('div').find("label").removeClass('d-none');
                    $(this).parent().siblings('div').find("label").html(data.data.type);

                } else {

                }
            }
        });
    });

</script>
<style>
    .edit,.save:hover{
        text-decoration: none!important;
    }
</style>
@endpush
