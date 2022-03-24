@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4>Survey Questions</h4>                               
            </div>
            <div class="table-responsive mt-4">
                <table class="table table-bordered">                 
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>                                            
                            <td>Survey 1</td>
                            <td>
                                <a href="{{route('pages.survey-1')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                            
                            <td>Survey 2</td> 
                            <td>
                                <a href="{{route('pages.survey-2')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                           
                            <td>Survey 3</td>
                            <td>
                                <a href="{{route('pages.survey-3')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                           
                            <td>Survey for obtain business</td>
                            <td>
                                <a href="{{route('pages.manage_pageForObtainBusiness')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                           
                            <td>Survey 4</td>    
                            <td>
                                <a href="{{route('pages.survey-4')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                            
                            <td>Survey 5</td> 
                            <td>
                                <a href="{{route('pages.survey-5')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                           
                            <td>Survey 6</td>  
                            <td>
                                <a href="{{route('pages.survey-6')}}">Manage</a>
                            </td>
                        </tr>    
                        <tr>                                           
                            <td>Survey 7</td>  
                            <td>
                                <a href="{{route('pages.survey-7')}}">Manage</a>
                            </td>
                        </tr>    

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection