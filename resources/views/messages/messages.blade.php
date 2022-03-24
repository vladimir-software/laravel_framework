@extends('layouts.elements.messages')
@section('content')
<div class="main-content">
    <div class="container-fluid">
        <div class="row">
            <section class="chat">
                <div class="header-chat">
                    <i class="fas fa-user"></i>
                    <p class="name"> 
                        @if(!empty($user['fullname']))
                            @if($user['fullname'] == "admin")
                                Support Team
                            @else
                                {{$user['fullname']}}
                            @endif
                        @endif
                    </p>
                </div>
                <div class="messages-chat"></div>
                <div class="footer-chat">
                    <input type="text" class="write-message" placeholder="Type your message here">
                    <input type="hidden" value="{{$user['id']}}">
                    <a class="icon send far fa-paper-plane clickable" href="javascript:void(0)"></a>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('messages.single_chat')   
<style>
    /*CHAT STYLES*/
    /* === CONVERSATIONS === */
    .discussions {
        width: 100%!important;        
    }

    .chat {
        width: 100%!important;
    }  
    .chat .messages-chat {
        padding: 25px 35px!important;
        height: 80vh;
        overflow: auto;
    } 

    .chat .messages-chat .text {
        margin: 0 0px !important;
        background-color: #ffffff;
        color: #000000;
        padding: 11px!important;
        border-radius: 12px!important;      
    }

    .footer-chat {
        width: 100%!important;
        height: 80px!important;
        display:flex!important; 
    }
    .chat .footer-chat .send {
        right: 10px!important;

    }   
</style>
@endpush
