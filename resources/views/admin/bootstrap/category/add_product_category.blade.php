@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">New Category</h4>           
            <form method="post" action="{{route('category.store-product-category1')}}" class="forms-sample serviceCategory">
                @csrf
                <div class="form-group">
                    <input type="text" name="product" class="form-control input-sm" placeholder="Product name" required="">
                </div>
                <button type="submit" class="btn btn-success mr-2">Add</button>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>

</script>
@endpush


