@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body">
                    <div class="d-inline-flex w-100">
                        <h4 class="card-title">Business</h4>                       
                    </div>
                    <div class="form-group">
                        <!--<label for="exampleFormControlSelect1">Large select</label>-->
                        <select name="business" class="form-control form-control-lg selectBusiness" id="exampleFormControlSelect1">
                            <option disabled='' selected="">--Select--</option>
                            <option value="product">Product</option>
                            <option value="services">Services</option>
                        </select>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row d-none" id="product-row">
    <div class="col-12 my-md-3"><h4 class="text-center">Products</h4></div>    
    <div class="col-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body"> 
                    @if(!empty($productCategory))
                    @foreach($productCategory as $key=> $data)
                    <ul>                        
                        <li>{{$data[0]['name']}} > {{$data[1]['name']}}</li>
                    </ul>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>    
</div>
<!--
<div class="row" id="product-row">
    <div class="col-12 my-md-3"><h4 class="text-center">New</h4></div>    
    <div class="col-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body"> 
                    @if(!empty($new))
                    @php  $a = 0; @endphp
                    @foreach($new as $key=> $data)
                    <ul>                        
                        <li>{{$data[0]['name']}} 

                            @if(isset($new1[$a][0]['name']) && $new1[$a][0]['name'] != '')
                            {{'>'.$new1[$a][0]['name']}} 
                            @endif
                            <br>
                            {{ $data[1]['name']}} 
                            @if(isset($new1[$a][1]['name']) && $new1[$a][1]['name'] != '')
                            {{'>'.$new1[$a][1]['name']}} 
                            @endif


                        </li>
                    </ul>
                    @php  $a++; @endphp
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>    
</div>-->


<div class="row d-none" id="service-row">
    <div class="col-12 my-md-3"><h4 class="text-center">Services</h4></div>    
    <div class="col-12">
        <div class="grid-margin stretch-card">
            <div class="card">              
                <div class="card-body">                  
                    @if(!empty($serviceCategory))
                    @foreach($serviceCategory as $key=> $data)
                    <ul>                        
                        <li>
                            <ol>
                                <li> {{$data['name']}} {{isset($serviceSubCategory[$key]['name'])?'> '.$serviceSubCategory[$key]['name']:''}}</li>
                                <li> {{$serviceMatchCategory[$key]['name']}}  {{isset($serviceMatchSubCategory[$key]['name'])?'> '.$serviceMatchSubCategory[$key]['name']:''}}</li>

                            </ol>

                        </li>                       


                    </ul>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>    
</div>

@endsection

@push('scripts')
<script>
    //selectBusiness
    $(document).on('change', '.selectBusiness', function () {
        var val = $(this).val();
        if (val != '' && val == 'product') {
            $('#service-row').addClass('d-none');
            $('#product-row').removeClass('d-none');
        } else if (val != '' && val == 'services') {
            $('#product-row').addClass('d-none');
            $('#service-row').removeClass('d-none');
        } else {
            alert('please select the required field');
            return false;
        }
    });
</script>
@endpush