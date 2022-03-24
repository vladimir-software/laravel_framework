@if(isset($matrix['home_status']) && $matrix['home_status'] == 1)
@include('main-page')
@else
@include('old')

@endif
