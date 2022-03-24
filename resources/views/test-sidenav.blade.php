@extends('main-page-layouts.app')
@section('content')
<div class="header"></div>
<input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
<label for="openSidebarMenu" class="sidebarIconToggle">
    <div class="spinner diagonal part-1"></div>
    <div class="spinner horizontal"></div>
    <div class="spinner diagonal part-2"></div>
</label>
<div id="sidebarMenu">
    <ul class="sidebarMenuInner">       
        <li>
            <a href="{{url('/')}}">Home</a>
        </li>
        <li>
            <a href="{{route('how-to-connect')}}">How to connect</a>
        </li>
        <li>
            <a href="{{route('pricing')}}">Pricing</a>
        </li>
        <li>
            <a href="{{route('contactUs')}}">Contact Us</a>
        </li>

    </ul>
</div>
<div id="overlay"></div>
@endsection
@push('scripts')
<script>
    $(document).on('click', '.clickMe', function () {
        $('#openSidebarMenu').prop('checked', true);
        $('.sidebarIconToggle').show();
        on();
    });
    $(document).on('click', '.sidebarIconToggle', function () {
        $('.sidebarIconToggle').hide();
        off()
    });

    function on() {
        document.getElementById("overlay").style.display = "block";
    }

    function off() {
        document.getElementById("overlay").style.display = "none";
    }
</script>
<style>
    #overlay {
        position: fixed; /* Sit on top of the page content */
        display: none; /* Hidden by default */
        width: 100%; /* Full width (cover the whole page) */
        height: 100%; /* Full height (cover the whole page) */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color:#000; /* Black background with opacity */
        opacity: .7;
        z-index: 1002; /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer; /* Add a pointer on hover */
    }
</style>
<style>   

    #sidebarMenu {
        height: 100%;
        position: fixed;
        right:  0;
        width: 400px;
        transform: translateX(400px);
        transition: transform 250ms ease-in-out;
        background: #000;
        z-index: 1005;
        padding-top: 150px;
        padding-left: 6%;
        transition: transform .7s cubic-bezier(.23,1,.32,1);
    }
    .sidebarMenuInner{
        margin:0;
        padding:0;
    }
    .sidebarMenuInner li{
        list-style: none;
        color: #fff;
        text-transform: uppercase;
        font-weight: bold;
        padding: 5px;
        cursor: pointer;
    }
    .sidebarMenuInner li span{
        display: block;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.50);
    }
    .sidebarMenuInner li a{
        font-size: 13px;
        font-weight: 600;
        font-style: normal;
        text-transform: uppercase;
        color: #ffffff;
        position: relative;
    }
    .sidebarMenuInner li a:after{
        content: ' ';
        position: absolute;
        width: 0;
        height: 2px;
        background-color: #fff;
        top: 50%;
        left: calc(100% + 13px);
        transition: width .15s;
    }
    .sidebarMenuInner li:hover  > a:after{
        width: 34px;
    }
    .openSidebarMenu:checked ~ #sidebarMenu {
        transform: translateX(0);
    }

    .openSidebarMenu {
        transition: all 0.3s;
        box-sizing: border-box;
        display: none;
    }
    .sidebarIconToggle {
        transition: all 0.3s;
        box-sizing: border-box;
        cursor: pointer;
        position: absolute;
        z-index: 9999;
        height: 100%;
        width: 100%;
        top: 25px;
        right: 30px;
        height: 20px;
        width: 22px;
        display: none;
    }  
    .spinner {
        transition: all 0.3s;
        box-sizing: border-box;
        position: absolute;
        height: 3px;
        width: 100%;
        background-color: #fff;
    }
    .horizontal {
        transition: all 0.3s;
        box-sizing: border-box;
        position: relative;
        float: left;
        margin-top: 3px;
    }
    .diagonal.part-1 {
        position: relative;
        transition: all 0.3s;
        box-sizing: border-box;
        float: left;
    }
    .diagonal.part-2 {
        transition: all 0.3s;
        box-sizing: border-box;
        position: relative;
        float: left;
        margin-top: 3px;
    }
    .openSidebarMenu:checked ~ .sidebarIconToggle > .horizontal {
        transition: all 0.3s;
        box-sizing: border-box;
        opacity: 0;
    }
    .openSidebarMenu:checked ~ .sidebarIconToggle > .diagonal.part-1 {
        transition: all 0.3s;
        box-sizing: border-box;
        transform: rotate(135deg);
        margin-top: 8px;
    }
    .openSidebarMenu:checked ~ .sidebarIconToggle > .diagonal.part-2 {
        transition: all 0.3s;
        box-sizing: border-box;
        transform: rotate(-135deg);
        margin-top: -9px;
    }
</style>
@endpush