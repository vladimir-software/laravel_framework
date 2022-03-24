@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="col-12 grid-margin">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">New FAQ</h4>           
            <form method="post" action="{{route('storeFAQ')}}" class="forms-sample serviceCategory">
                @csrf
                <div class="form-group">
                    <label for="question">Question</label>
                    <input type="text" name="question" class="form-control input-sm" placeholder="Question" required="">
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <textarea name="answer" rows="5" class="form-control" required=""></textarea>
                </div>
                <button type="submit" class="btn btn-success mr-2">Add</button>
            </form>
        </div>
    </div>
</div>

@endsection