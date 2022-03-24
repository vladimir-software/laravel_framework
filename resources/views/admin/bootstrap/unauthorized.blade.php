@extends('admin.bootstrap.layouts.app')
@section('content')
<section class="sign-up-bg">
 <p><u>Unauthorized</u>: Root Administrators Only</p>
</section>
@endsection
@push('scripts')
<style>
    .form-group .input-group-text{
        border: none;
        background: transparent;
    }
    html, body {
        height: 100%;

    }
    .matched-success{
        color: #28a745;
    }

    ::placeholder{
        font-size: 14px;
    }
    body {

    }
</style>
@endpush
