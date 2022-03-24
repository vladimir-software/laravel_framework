@if(isset($pageName) && $pageName == 'page_3')
<form method="post" action="javascript:void(0);" class="surveyForms" id="submitEditedPrimaryGoals">
    @csrf
    <input name="page_name" hidden="" value="page_3">  
    <label  class="mainHeading mb-3">Primary Goals</label>
    <div class="alert alert-danger alert-dismissible fade show d-none errorForObtainingServices" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error! </strong> <span class="errorMessage"></span>
    </div>
    @if(isset($data) && $data != "")
    @foreach($data as $key=> $value)
    <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">
        <input class=" mr-3 surveyCheckBox" name="answer[]" type="checkbox"  value="{{$value['content']}}" id="defaultCheck{{$key}}" style="margin-top: 0.3rem !important;"  @if(isset($val) && in_array($value['content'],$val)) checked @endif>
               <label class="form-check-label mb-2 suveyLabel" for="defaultCheck{{$key}}">{{$value['content']}}</label>
    </div>
    @endforeach
    @endif
    <div class="text-center mt-5 mb-3">                                          
        <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
    </div> 
</form> 

@elseif(isset($pageName) && $pageName == 'pageForObtainBusiness')
<div id="categoryContainer" style="display:none;">
    <label class="form-check-label suveyLabel mt-3" style="color: #333;" for="defaultCheck1">Please select a category</label>   
    <div>
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
            <label class="form-check-label suveyLabel" style="color: #333;" for="defaultCheck1">Please select a sub category</label>
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
        <div style="display:none;" class="textForOther">
            <label class="form-check-label suveyLabel" style="color: #333;" for="otherVal">Description</label>   
            <textarea  class="otherVal w-100 pl-2"></textarea>
        </div>
        <div class="appendErrorForSameServies text-center text-danger mt-3"></div>
    </div>
    <div class="nextSurvey">      
        <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
        <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
    </div>
</div>

<form method="post" action="javascript:void(0);" class="submitEditedObtainServices" id="categoryForm">
    @csrf
    <input name="page_name" hidden="" value="pageForObtainBusiness">  
    <input name="other" hidden="" value="" class="otherValue">  
    <div class="alert alert-danger alert-dismissible fade show d-none errorForObtainServices" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error! </strong> <span class="errorMessageForObtainServices"></span>
    </div>
    @if(!empty($is_exist))
    <label  class="mainHeading   mb-3">Services</label>
    <table class="table table-responsive-sm text-left">
        <tbody id="appendCategory">
            @foreach($is_exist as $dd)
            <tr>  
                <td>
                    <input hidden="" value="{{$dd['cat_id']}}" name="category[]">
                    <span class="catName">{{$dd['cat_name']}}</span>
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
    <div class="mt-5 mb-5 btnChangeClass">
        <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @else
    <table class="table table-responsive-sm text-left" style="display:none;">
        <tbody id="appendCategory">

        </tbody>
    </table>
    <div class="text-center mt-5 mb-5 btnChangeClass text-left">
        <a class="text-success addMoreCategory" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @endif
    <div class="text-center mt-5 mb-3">                                          
        <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
    </div> 
</form>

@elseif(isset($pageName) && $pageName == 'page_4')
<div id="categoryContainer" style="display:none;"> 
    <label class="form-check-label suveyLabel mt-3" style="color: #333;" for="defaultCheck1">Please select a category</label>
    <div>
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
            <label class="form-check-label suveyLabel" style="color: #333;" for="defaultCheck1">Please select a sub category</label>
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
        <div style="display:none;" class="textForOther">
            <label class="form-check-label suveyLabel" style="color: #333;" for="otherVal">Description</label>   
            <textarea  class="otherVal w-100 pl-2"></textarea>
        </div>
        <div class="appendErrorForSameServies text-center text-danger mt-3"></div>
    </div>
    <div class="nextSurvey">
        <!--<a href="{{route('skipEditSurveyQuestion','page_4')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>-->
        <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
        <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
    </div>
</div>

<form method="post" action="javascript:void(0);" class="surveyForms editServicesModal submitEditedServices" id="categoryForm">
    @csrf  
    <input name="page_name" hidden="" value="page_4">
    <input name="other" hidden="" value="" class="otherValue">
    <div class="alert alert-danger alert-dismissible fade show d-none errorForServices" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error! </strong> <span class="errorMessageForServices"></span>
    </div>
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
    <div class="my-2 btnChangeClass text-left">
        <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @else
    <label  class="mainHeading mb-0 mt-4">Services</label>
    <table class="table table-responsive-sm" style="display:none;">
        <tbody id="appendCategory">

        </tbody>
    </table>
    <div class="text-center my-2 btnChangeClass">
        <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
    </div>
    @endif

    <label  class="mainHeading mb-0 mt-3">Description</label>
    <input hidden="" value="Describe your product in detail" name="question" >
    <textarea class="form-control" rows="5" onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data1['answer']}}"  required="required">{{$data1['answer']}}</textarea>
    <p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>


    <div class="text-center my-3">                                          
        <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
    </div> 
</form>

@elseif(isset($pageName) && $pageName == 'page_5')
<div id="categoryContainer" style="display:none;"> 
    <label class="form-check-label suveyLabel mt-3" style="color: #333;" for="defaultCheck1">Please select a category</label>
    <div>
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
            <label class="form-check-label suveyLabel" style="color: #333;" for="defaultCheck1">Please select a sub category</label>
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
        <div style="display:none;" class="textForOther">
            <label class="form-check-label suveyLabel" style="color: #333;" for="otherVal">Description</label>   
            <textarea  class="otherVal w-100 pl-2"></textarea>
        </div>
        <div class="appendErrorForSameServies text-center text-danger mt-3"></div>
    </div>
    <div class="nextSurvey mt-4 ">
        <!--<a href="{{route('skipEditSurveyQuestion','page_4')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>-->
        <button type="button" class="btn btn-sm btn-success float-right addSelectCat">Add</button>
        <a href="#" onclick=" $('#categoryContainer').hide();$('#categoryForm').show();" class="btn btn-sm btn-primary  text-white float-right  mr-2" rel="">Cancel</a>
    </div>
</div>
<form method="post" action="javascript:void(0);" class="editProductModal submitEditedProductServices" id="categoryForm">
    @csrf
    <input name="page_name" hidden="" value="page_5">
    <input name="other" hidden="" value="" class="otherValue">
    <div class="alert alert-danger alert-dismissible fade show d-none errorForProductServices" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Error! </strong> <span class="errorMessageForProductServices"></span>
    </div>
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



@if(!empty($is_exist_product))
<label  class="mainHeading mb-0 mt-2">Services</label>
<table class="table table-responsive-sm text-left">
    <tbody id="appendCategory">
        @foreach($is_exist_product as $dd)
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
<div class="my-2 btnChangeClass text-left">
    <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
</div>
@else
<label  class="mainHeading mb-0 mt-2">Services</label>
<table class="table table-responsive-sm" style="display:none;">
    <tbody id="appendCategory">

    </tbody>
</table>
<div class="text-center my-2 btnChangeClass">
    <a class="text-success addMoreCategory small" href="javascript:void(0)"><u>+ Add category</u></a>
</div>
@endif

<label class="mainHeading mb-0 ">Description</label> 
<input hidden="" value="Describe your product in detail" name="question" >
<textarea class="form-control" rows="5" onkeyup="countTitle(this)" max-length="300"  name="answer" value="{{$data['answer']}}" required="required">{{$data['answer']}}</textarea>
<p class="float-right d-none" id="charNum3" style="color:#ff7c00">300</p>


<div class="my-3 text-center ">                                          
    <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
</div> 
</form>

@elseif(isset($pageName) && $pageName == 'page_6')

<form method="post" action="{{route('submitEditedSurvey5')}}">
    @csrf
    <label  class="mainHeading   mb-3">Location</label>    
    <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">
        <div class="input-group flex-nowrap">
            <input id="pac-input" name="answer" type="text" value="{{$val['answer']}}" class="form-control border-right-0 searchLocation" placeholder="Search location here..." >
            <input type="hidden" value="{{$val['answer']}}" id="getLatLng" name="lat_lng">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white border-left-0" id="addon-wrapping"><i class="fas fa-search" style="font-size:16px!important"></i></span>
            </div>
        </div>
    </div>                      
    <div class="text-center mt-5 mb-3">                                          
        <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
    </div>  
</form>
@endif


