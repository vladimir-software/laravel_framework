@extends('admin.bootstrap.layouts.app')
@section('content')
<script src="/js/jquery.min.js" ></script>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">           
            <h4 class="card-title">Messages</h4>     
            <button id="delete-messages" class="btn btn-danger" style="font-size:11px;" disabled='disabled'>Delete Selected</button>     
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" value="0" id="contact_message_all" name="contact_message_all">
                            </th>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email Address</th>
                            <th>Contact #</th>                                                          
                            <th>Message</th>                                                          
                            <!--<th>Actions</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($mesages))
                        @foreach($mesages as $key=> $data)
                        <tr>
                            <td>                        
                                <input type="checkbox" id="contact_message_{{$data['id']}}" value="{{$data['id']}}" name="contact_message_{{$data['id']}}" class="message_checkbox">
                            </td>
                            <td>{{++$key}}</td>
                            <td>{{$data['firstname']}}</td>
                            <td>{{$data['lastname']}}</td>
                            <td>{{$data['email']}}</td>                           
                            <td>{{$data['mobile_number']}}</td>                          
                            <td>
                                <div style="height:150px;overflow-y: scroll" class="inner-border">{{$data['message']}}</div>
                            </td>                          
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>               
            </div>   
            <div class="float-right mt-4">
                <span class="ml-auto">{{$mesages->links()}}</span>
            </div>
        </div>
    </div>
</div>
@endsection
