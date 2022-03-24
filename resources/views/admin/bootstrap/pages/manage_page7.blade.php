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
                    @php $counter = 1; $count = count($list);@endphp
                    <div class="list-wrapper">
                        <form method="post" action="{{route('save-question1')}}"> 
                            <input type="text" class="form-control input-sm" name="page_name" hidden="" value="page_7">
                            @csrf
                            <ul class=" appendForm">
                                @if(!$list->isEmpty())
                                @foreach($list as $key=> $data)
                                <li>
                                    <div class="">
                                        <!--<input type="text" name="question[]"  value="{{$data->content}}" hidden="">-->
                                        <label class="form-check-label"> {{$data->content}} </label>
                                    </div> 
                                    <div class="ml-auto">
                                        <a href="javascript:void(0);" rel="DOWN" order-id="{{$data['id']}}" class="sortOrder @if($counter == $count) d-none @endif" @if($counter == 1) style="margin-right:1.5rem!important"@endif>
                                           <i class="fas fa-arrow-down mr-2"></i>
                                        </a>
                                        <a href="javascript:void(0);" rel="UP" order-id="{{$data['id']}}" class="sortOrder @if($counter == 1) d-none  @endif mr-3"  @if($counter == $count) style="margin-right:1.5rem!important"@endif>
                                           <i class="fas fa-arrow-up"></i>
                                        </a>

                                        <a href="javascript:void(0);" class="edit mr-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="d-none save mr-1" rel="{{$data['id']}}">
                                            <i class="globalIconsStyle saveIcon fas fa-save"></i>
                                        </a>
                                        <a href="{{route('deleteSurveyQuestion',$data['id'])}}" class="mr-1" style="color:red" rel="{{$data['id']}}">
                                            <i class="fas fa-trash small remove" style="font-size:1rem"></i>
                                        </a>
                                    </div>
                                </li>
                                @php $counter++;  @endphp
                                @endforeach
                                @endif
                            </ul>
                            <div  class="mt-4 text-right">
                                <button type="submit" class="btn btn-success mr-2 saveForPage7">Save</button>
                                <a href="javascript:void(0)" class="btn btn-primary d-none saveForPage7" onclick="location.reload();">Cancel</a>
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
<style>
    .sortOrder:hover{
        text-decoration: none!important;
    }
    .fa-arrow-down, .fa-arrow-up{
        color: #17c5c0!important;
    }
    .fa-edit{
        color:#03a9f3!important;
    }
</style>
<script>

    $(document).on('click', '.sortOrder', function () {
        var sortIdFrom = $(this).attr('order-id');
        var sortOrder = $(this).attr('rel');

        switch (sortOrder) {
            case 'UP':

                var sortFrom = $(this).parents('li').find('label').text();
                var sortTo = $(this).parents('li').prev().find('label').text();
                var sortIdTo = $(this).parents('li').prev().find('.sortOrder').attr('order-id');

                $(this).parents('li').find('label').text(sortTo);
                $(this).parents('li').prev().find('label').text(sortFrom);

                break;

            case 'DOWN':

                var sortFrom = $(this).parents('li').find('label').text();
                var sortTo = $(this).parents('li').next().find('label').text();
                var sortIdTo = $(this).parents('li').next().find('.sortOrder').attr('order-id');

                $(this).parents('li').find('label').text(sortTo);
                $(this).parents('li').next().find('label').text(sortFrom);

                break;

            default:
                alert('Failed');
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/sortOrderForSurvey7",
            data: {sortIdFrom: sortIdFrom, sortIdTo: sortIdTo, sortFrom: sortFrom, sortTo: sortTo},
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

    $(document).on('click', '.remove', function () {
        $(this).parents('li').remove();
        
    });

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
                    '          <i class="remove fas fa-trash" style="font-size:1rem"></i> ' +
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
//        /alert(id);return false;
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
                    $(this).parent().siblings('div').find("label").html(data.data.content);

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
