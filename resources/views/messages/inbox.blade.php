@extends('layouts.elements.app')
@section('content')
<div class="container-fluid">
    
    <div class="row" style="background-color:white; border-bottom: 1px solid black; border-top: 1px solid black; background-color: rgba(0, 0, 0, 0.03); padding-top: 10px;"> 
        <h2 style="padding-left: 10px; color: #000"><i class="fas fa-envelope"></i> Inbox</h2>
    </div>
    <div class="row"> 
        <section class="discussions">
            @foreach($inbox as $key=> $data)
                @if (!empty($data['sender_id']))        
                    <div class="discussion getChat @if($key == 0) message-active @endif" sender-id="{{$data['sender_id']}}" sender-name="{{$data['name']}}">
                        <div class="photo" style="background-image: url({{isset($data['image'])? $data['image'] : ''}}); min-width: 50px;">
                            <!--div class="online"></div-->
                            <br/><p class="small-name">{{(($data['name'] == 'admin')?"Support Team":$data['name'])}}</p>
                        </div>
                        <div class="desc-contact">
                            <p class="name">{{(($data['name'] == 'admin')?"Support Team":$data['name'])}}</p>
                            <p class="message">{{$data['message']}}</p>
                        </div>
                        <div class="timer">{{$data['message_time']}}</div>
                    </div>
                @endif
            @endforeach
        </section>
        <section class="chat">
            <div class="header-chat">
                <p class="name chat-name"></p>
            </div>
            <div class="messages-chat"></div>
            <div class="footer-chat">
                
                <input type="text" class="write-message" placeholder="message here..." style="margin: 10px;"/>
                <input type="hidden" id="senderId"/>
                <i class="fa fa-paper-plane" style="position: absolute;right: 20px;"></i> 
            </div>
        </section>
    </div>
</div>
<style>

    .discussions .message-active {
         border-top: 0;
    }

    .small-name {
        display:none;
    }
    
    .timer {
        padding: 2px;
        border-radius: 0px;
        border:unset;
        float:left;
        margin: 0px;
    }
    
    .discussions .discussion .message {
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 150px;
    }

    @media only screen and (max-width: 765px) {
        .desc-contact {
            display:none;
        }
        .timer {
            display:none;
        }
        
        .small-name {
            display:block;
            min-width: 200px;
            padding: 0px;
            margin-top: 15px;
            color:#515151;
        }
        
        .discussions .discussion {
            height: 110px;
        }
    }


</style>


@endsection
@push('scripts')
@include('messages.chat')   
@endpush

