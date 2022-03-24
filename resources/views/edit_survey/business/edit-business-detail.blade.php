
@if(isset($pageName) && $pageName == 'page_5')
<form method="post" action="{{route('submitEditedSurvey4')}}" class="" >
    @csrf
    <input name="page_name" hidden="" value="page_5">

    @if(!empty($productIndustry))
    <label class="mainHeading mb-0 ">Industry</label>   
    <div class="input-group mb-3">
        <select name="industry[]"  class="multiple-industry w-100 mb-3"  multiple="multiple">                                   

            @foreach($productIndustry as $key=> $sat) 
            <option value="{{$sat['id']}}" 
                    @if(isset($data['industry'])) 
                    @php echo in_array($sat['id'], $data['industry']) ? 'selected=selected' : '' @endphp
                    @endif 
                    >{{$sat['name']}}</option>  
            @endforeach 

        </select>
    </div> 
    @endif

    @if(!empty($productCategory))
    <label  class="mainHeading mb-0">Products</label>                        
    <div class="input-group mb-3">    
        <select name="type_of_product[]"  class="multiple-product w-100 mb-3"  multiple="multiple">       
            @foreach($productCategory as $key=> $pat)
            <option value="{{$pat['id']}}" 
                    @if(isset($data['type_of_product'])) 
                    @php echo in_array($pat['id'], $data['type_of_product']) ? 'selected=selected' : '' @endphp
                    @endif 
                    >{{$pat['name']}}
        </option>  
        @endforeach        
    </select>
</div>
@endif

@if(isset($data['answer']) && $data['answer'] != '')
<label class="mainHeading mb-0 ">Description</label> 
<input hidden="" value="Describe your product in detail" name="question" >
<textarea class="form-control"  onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data['answer']}}" required="required">{{$data['answer']}}</textarea>
<p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>
@endif

<div class=" mt-5 mb-3 text-center ">                                          
    <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
</div> 
</form>


@elseif(isset($pageName) && $pageName == 'page_4')
<label  class="mainHeading d-hide d-none  my-3">Services</label>
<div id="categoryContainer" style="display:none;">  
    <div class="input-group">                                       
        <select name="category" class="custom-select getSubCategory mb-3" >                                    
            <option value="" >---Select----</option>  
            @if(!empty($serviceCategory))
            @foreach($serviceCategory as $cat)                                    
            <option value="{{$cat['id']}}">{{$cat['name']}}</option>  
            @endforeach
            @endif
        </select>
    </div>    
    <div class="hideSubCat" style="display:none;">
        <div class="input-group">                                       
            <select name="sub_category" class="custom-select setSubCategory" >
                <option value="">---Select----</option> 
                @if(!empty($serviceSubCategory))                                            
                @foreach($serviceSubCategory as $cat2)
                <option value="{{$cat2['id']}}">{{$cat2['name']}}</option>  
                @endforeach
                @endif
            </select>
        </div>
    </div>  
    <div class="nextSurvey">
        <!--<a href="{{route('skipEditSurveyQuestion','page_4')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>-->
        <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
        <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
    </div>
</div>

<form method="post" action="{{route('submitEditedSurvey3')}}" class="surveyForms editServicesModal" id="categoryForm">
    @csrf  
    <input name="page_name" hidden="" value="page_4">
    @if(!empty($categoryIndustry))
    <label class="mainHeading mb-0">Industry</label> 
    <div class="input-group"> 
        <select name="industry[]"  class="js-category-industry w-100 mb-3"  multiple="multiple">           
            @foreach($categoryIndustry as $key=> $sat)
            <option value="{{$sat['id']}}" @if(isset($data1['industry'])?in_array($sat['id'], $data1['industry']):'') selected @endif>{{$sat['name']}}</option>  
            @endforeach
        </select>
    </div>
    @endif

    @if(!empty($is_exist))
    <label  class="mainHeading mb-0 mt-3">Services</label>
    <table class="table table-responsive-sm text-left">
        <tbody id="appendCategory">
            @foreach($is_exist as $dd)
            <tr>  
                <td>
                    <input hidden="" value="{{$dd['cat_id']}}" name="category[]">{{$dd['cat_name']}}
                </td>
                <td> 
                    <input hidden="" value="{{$dd['sub_cat_id']}}" name="sub_category[]">{{isset($dd['sub_cat_name'])? $dd['sub_cat_name'] :"---"}}
                </td>  
                <td>
                    <a href="#" class="deleteCat small"><i class="fas  fa-trash text-danger"></i></a>
                </td>  
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-2 btnChangeClass text-left">
        <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @else
    <table class="table table-responsive-sm" style="display:none;">
        <tbody id="appendCategory">

        </tbody>
    </table>
    <div class="text-center mt-2 btnChangeClass">
        <a class="text-success addMoreCategory sma" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @endif
    @if(isset($data1['answer']) && $data1['answer'] != '')
    <label  class="mainHeading mb-0 mt-3">Description</label>
    <input hidden="" value="Describe your product in detail" name="question" >
    <textarea class="form-control"  onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data1['answer']}}"  required="required">{{$data1['answer']}}</textarea>
    <p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>
    @endif

    <div class="text-center mt-5 mb-3">                                          
        <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
    </div> 
</form>

@endif
