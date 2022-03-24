@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">New Category</h4>           
            <form method="post" action="{{route('category.store-service-category1')}}" class="forms-sample serviceCategory">
                @csrf
                <div class="form-group">
                    <input type="text" name="category" class="form-control input-sm" placeholder="Category name" required="">
                </div>
                <div style="margin-bottom: 20px;" class="text-right">
                    <a href="javascript:void(0)" class=" addSubCategory lightblue-icon-notika btn-reco-mg btn-button-mg waves-effect" style="margin-left: auto">
                        <i class="fa fa-plus"></i>   <span style="text-decoration: underline">add sub-category</span>                           
                    </a>
                </div>
                <div class="appendInputForSubCategory">

                </div>
                <button type="submit" class="btn btn-success mr-2">Add</button>
            </form>
        </div>
    </div>
</div>


<!--/addSubCategory-->
@endsection

@push('scripts')
<script>

    $(".addSubCategory").on('click', function (e) {
        $(".appendInputForSubCategory").append('<div class="subInput" style="margin-bottom: 2rem;">\n\
<div class="form-group"><div class="nk-int-st" style="display: flex;">\n\
<input type="text" name="sub_cat_name[]" class="form-control input-sm" placeholder="sub category name" required="">\n\
<a class="info-icon-notika waves-effect removeSubCategory">\n\
<i class="fas fa-times ml-2" aria-hidden="true" style="margin-top: 10px;font-size: 16px;"></i> </a>\n\
</div></div></div>  ');
    });

    $(document).on('click', ".removeSubCategory", function (e) {
        $(this).parents('.subInput').remove();
    });
</script>
@endpush


