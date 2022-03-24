@extends('layouts.elements.app')
@section('content')
<div class="container-fluid">
    <div class="row"> 
        <section class="discussions">
            <div class="discussion search">
                <div class="searchbar">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <input type="text" placeholder="Search..."></input>
                </div>
            </div>
            @foreach($inbox as $data)
            <div class="discussion message-active" sender-id="{{$data['sender_id']}}">
                <div class="photo" style="background-image: url({{isset($data['image'])? $data['image'] : ''}}}});">
                    <div class="online"></div>
                </div>
                <div class="desc-contact">
                    <p class="name">{{$data['name']}}</p>
                    <p class="message">{{$data['message_time']}}</p>
                </div>
                <div class="timer">12 sec</div>
            </div>
            @endforeach
        </section>
        <section class="chat">
            <div class="header-chat">
                <i class="icon fa fa-user-o" aria-hidden="true"></i>
                <p class="name">Megan Leib</p>
                <i class="icon clickable fa fa-ellipsis-h right" aria-hidden="true"></i>
            </div>
            <div class="messages-chat">
                <div class="message">
                    <div class="photo" style="background-image: url(https://image.noelshack.com/fichiers/2017/38/2/1505775062-1505606859-portrait-1961529-960-720.jpg);">
                        <div class="online"></div>
                    </div>
                    <p class="text"> Hi, how are you ? </p>
                </div>
                <div class="message text-only">
                    <p class="text"> What are you doing tonight ? Want to go take a drink ?</p>
                </div>
                <p class="time"> 14h58</p>
                <div class="message text-only">
                    <div class="response">
                        <p class="text"> Hey Megan ! It's been a while 😃</p>
                    </div>
                </div>
                <div class="message text-only">
                    <div class="response">
                        <p class="text"> When can we meet ?</p>
                    </div>
                </div>
                <p class="response-time time"> 15h04</p>
                <div class="message">
                    <div class="photo" style="background-image: url(https://image.noelshack.com/fichiers/2017/38/2/1505775062-1505606859-portrait-1961529-960-720.jpg);">
                        <div class="online"></div>
                    </div>
                    <p class="text"> 9 pm at the bar if possible 😳</p>
                </div>
                <p class="time"> 15h09</p>
            </div>
            <div class="footer-chat">
                <i class="icon fa fa-smile-o clickable" style="font-size:25pt;" aria-hidden="true"></i>
                <input type="text" class="write-message" placeholder="Type your message here"></input>
                <i class="icon send fa fa-paper-plane-o clickable" aria-hidden="true"></i>
            </div>
        </section>
    </div>
</div>

@endsection

@push('styles')

@endpush
