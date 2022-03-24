<div class="navigation-wrap bg-light start-header start-style">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="navbar navbar-expand-md navbar-light main-navbar">
                    <a class="navbar-brand"   
                       @if(!empty(Auth::id())) 
                       @if(Route::currentRouteName() != 'index')  
                       href="{{route('home')}}" 
                       @endif

                       @else

                       @if(Route::currentRouteName() != 'index')
                       href="{{route('index')}}"
                       @endif       
                       @endif       
                       >
                       <img src="{{asset('asset/logo_mobile.png')}}" alt="">
                    </a>                 
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto py-4 py-md-0 ">
                            @if(isset(auth()->user()->id) && auth()->user()->id != '')
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 ">
                                <a class="nav-link text-center" href="{{route('home')}}">
                                    <i class="fas fa-home navbarIcon" style="font-size: 23px;"></i>
                                    <div>Home</div>
                                </a>
                            </li>
                            
                            @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type > 1)
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4 ">
                                <a class="nav-link text-center" href="{{route('videos')}}">
                                    <i class="fas fa-video navbarIcon" style="font-size: 23px;"></i>
                                    <div>Videos</div>
                                </a>
                            </li>
                            @endif
                            
                            @if(isset(auth()->user()->approval) && auth()->user()->approval == 1)
                            @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type != 1)
                            @php $userNotification = App\Models\Messages::where(['receiver_id'=>Auth::id()])->limit(10)->orderBy('created_at', 'DESC')->get()  @endphp
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="nav-link dropdown-toggle count-indicator  text-center" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" style="color:#ff7c00"  aria-expanded="false">
                                    @php  $data = App\Models\Messages::where(['receiver_id'=>Auth::id(), 'read' => 0])->orderBy('created_at', 'DESC')->get();  @endphp          
                                    @if(count($data) > 0)
                                    <div class="notificationCount d-none d-md-block">
                                        <span class="count">  {{ count($data) }}</span>
                                    </div>                                 
                                    @endif
                                    <i class="far fa-bell navbarIcon" style="font-size: 23px;"></i>
                                    <div>Notifications</div>                                   
                                </a>
                                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown" style="border: none;width:350px!important;">
                                    <div class="dropdown-item mb-2" style="height:29px;border-bottom: 1px solid #e4e4e4;background:#ff7c00">
                                        <h6 class="mb-0 font-weight-normal float-left text-white  mb-2" style="letter-spacing: .5px;font-family: roboto;">Notifications</h6>
                                    </div> 
                                    <div class="appendNotification">
                                        @if(!$data->isEmpty())
                                            @foreach($data as $dd)
                                                @if($dd->getSenderData)
                                                <div class="dropdown-item preview-item">
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <a href="{{route('messages.messages',$dd->getSenderData->id)}}" class="text-center">
                                                                <div class="preview-thumbnail">
                                                                    <img src="{{isset($dd->getSenderData->profile_pic)?$dd->getSenderData->profile_pic:asset('asset/noimage_person.png')}}" alt="image" style="width: 35px;height: 35px;border-radius: 50%;">
                                                                </div>     
                                                            </a>
                                                        </div>
                                                        <div class="col-10">
                                                            <a href="{{route('messages.messages',$dd->getSenderData->id)}}">
                                                                <div class="preview-item-content flex-grow w-100">                                                      
                                                                    <h6 class="preview-subject ellipsis  text-dark  mb-0" style="font-size: 14px;font-weight: 700;">
                                                                        {{(($dd->getSenderData->fullname == 'admin')?"Support Team":$dd->getSenderData->fullname)}} <span style="font-size: 12px;font-weight:500">sent you a message.</span>
                                                                     </h6> 
                                                                     <span class="small-text" style="color:#000;font-size:10px;font-weight: 500;">{{$dd->created_at->diffForHumans()}}</span>
                                                                    <!--<p style="font-size:12px">{{$dd->message}}</p>-->
                                                                </div>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>                    
                                </div>
                            </li>
                            @endif
                            @endif
                            <!--END NOTIFICATIONS-->    
                            <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="nav-link dropdown-toggle count-indicator  text-center" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" style="color:#ff7c00"  aria-expanded="false">
                                    <img class="navbarIcon rounded-circle img-center img-fluid shadow shadow-lg--hover" src="{{(isset(Auth::user()->profile_pic) ? asset(Auth::user()->profile_pic) : asset('/asset/noimage_person.png'))}}" alt="user-image" width="28px" height="28px" style="border-radius:5px;">
                                    <div >@if(isset(Auth::user()->fullname) && Auth::user()->fullname != '')
                                        <span class="text-capitalize">{{ Auth::user()->fullname}}</span>
                                        @else
                                        {{ Auth::user()->email}}
                                        @endif
                                    </div>
                                </a>
                                <div class="dropdown-menu bg-white dropdown-menu-right navbar-dropdown preview-list mainNavbarDropdownMenu" aria-labelledby="messageDropdown" style="border: none;">
                                    @if(isset(auth()->user()->approval) && auth()->user()->approval == 1)
                                    <a href="{{route('users.my-profile')}}"  class="btn btn-outline-success dropdown-item">
                                        <i class="fas fa-user"></i>My Profile   
                                    </a>                                    
                                    <a href="{{route('users.business-profile')}}"  class="btn btn-outline-success dropdown-item">
                                        <i class="fas fa-business-time"></i>My Offerings
                                    </a>                                 
                                    @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type != '')
                                    @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type != 1)
                                    <a href="{{route('messages.inbox')}}" class="btn btn-outline-success dropdown-item">
                                        <i class="far fa-comments"></i>My Inbox  
                                    </a>
                                    @endif
                                    @endif                                    
                                    <a href="{{ route('user.connect-leads')}}" class="btn btn-outline-success dropdown-item">
                                        <i class="far fa-building"></i>My Connections
                                    </a>                                   
                                    <a href="{{ route('subscription')}}"  class="btn btn-outline-success dropdown-item">
                                        <i class="fas fa-comment-dollar"></i>Subscription Plans   
                                    </a>
                                    <a href="{{route('user_ratings')}}" class="btn btn-outline-success dropdown-item">
                                        <i class="fas fa-star"></i>Ratings  
                                    </a>
                                    <a href="{{ route('logout') }}"  class="btn btn-outline-success dropdown-item " data-toggle="tooltip" title="Logout" onclick="localStorage.removeItem('profilePic')">
                                        <i class="fas fa-sign-out-alt"></i>Log out   
                                    </a>
                                    @else
                                    <a href="{{ route('logout') }}" class="btn btn-outline-success dropdown-item " data-toggle="tooltip" title="Logout" onclick="localStorage.removeItem('profilePic')">
                                        <i class="fas fa-sign-out-alt"></i>Log out   
                                    </a>
                                    @endif   
                                    <hr/>
                                    <a href="{{route('side_menu_items.contact_us')}}" class="btn btn-outline-success dropdown-item">
                                        <i class="fas fa-envelope"></i>Contact
                                    </a>
                                    <a href="https://www.shopconnecteo.com" class="btn btn-outline-success dropdown-item " data-toggle="tooltip" title="ShopConnectEO" target="_blank">
                                        <i class="fas fa-shopping-cart"></i>Shop
                                    </a>
                                </div>
                            </li>
                            @if(isset(auth()->user()->approval) && auth()->user()->approval == 1)
                            @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type == "" || isset(auth()->user()->subscription_type) && auth()->user()->subscription_type == 1)
                            <li class="pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="btn goPremium bg-white" style="margin-top: 8px;" href="{{route('subscription')}}">Go Premium</a>
                            </li>
                            @elseif(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type == 2)
                            <li class="pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="btn goPremium bg-white" style="margin-top: 8px;"  href="{{route('subscription')}}">Go Platinum</a>
                            </li>
                            @endif  
                            @endif  

                            @else
                            <li class="pl-4 pl-md-0 ml-0 ml-md-4">
                                <a class="btn btn-md  btn-success " href="{{route('signup')}}" style="margin-top: 8px;">Sign Up</a>
                            </li>
                            @endif 
                        </ul>
                    </div>
                </nav>		
            </div>
        </div>
    </div>
</div>
<style>
    .main-navbar .mainNavbarDropdownMenu{
        z-index: 99999!important;
    }
    .main-navbar .mainNavbarDropdownMenu a{
        font-size: 14px!important;

    }
    .main-navbar .mainNavbarDropdownMenu i{
        width: 25px;
        font-size: 14px;       
    }

    .main-navbar .MobilesearchDropdown {
        position: absolute;
        z-index: 9999;
        border: 1px solid #ddd!important;
        border-radius: 5px!important;
        background-color: #fff!important;
        top: 0px;
        right: 0;
        width: 350px;
        left: 0px;
    }

    .main-navbar .MobilesearchDropdown li {
        margin: 0;
        padding: 0;
        width: 100%;
        border-bottom: 1px solid #cecece;
        padding: 6px!important;
    }

    .main-navbar .MobilesearchDropdown ol, ul, li, a {
        padding: 0px;
        list-style: none;
        text-decoration: none!important;

    }

    .main-navbar .responsive img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .main-navbar .MobilesearchDropdown h6 {
        font-size: 12px;
    }


    .main-navbar .customSearchList{
        position: absolute;
        z-index: 1111;
        top: 50px;
        width: 100%;
    }
    .main-navbar .goPremium{
        border:1px solid #ff7c00!important;
        color: #ff7c00!important;
    }
    .main-navbar .goPremium:hover{
        background: #ff7c00!important;
        color: #fff!important;
    }
    .main-navbar #inlineFormInputGroup:focus{
        border: 1px solid #ced4da!important;
        border-left: none!important;
    }
    .start-header {
        opacity: 1;
        padding: 10px 0;
        box-shadow: 0 10px 30px 0 rgba(138, 155, 165, 0.15);
        -webkit-transition : all 0.3s ease-out;
        transition : all 0.3s ease-out;
    }
    .start-header.scroll-on {
        box-shadow: 0 5px 10px 0 rgba(138, 155, 165, 0.15);
        padding: 5px 0;
        -webkit-transition : all 0.3s ease-out;
        transition : all 0.3s ease-out;
    }
    .start-header.scroll-on .navbar-brand img{
        height: 28px;
        -webkit-transition : all 0.3s ease-out;
        transition : all 0.3s ease-out;
    }
    .navigation-wrap{
        width: 100%;
    }
    .navbar{
        padding: 0;
    }
    .main-navbar .navbar-brand img{
        height: 52px;
        width: auto;
        display: block;
        -webkit-transition : all 0.3s ease-out;
        transition : all 0.3s ease-out;
    }
    .main-navbar .navbar-toggler {
        float: right;
        border: none;
        padding-right: 0;
    }
    .main-navbar .navbar-toggler:active,
    .navbar-toggler:focus {
        outline: none;
    }
    .navbar-light .navbar-toggler-icon {
        width: 24px;
        height: 17px;
        background-image: none;
        position: relative;
        border-bottom: 1px solid #000;
        transition: all 300ms linear;
    }
    .navbar-light .navbar-toggler-icon:after, 
    .navbar-light .navbar-toggler-icon:before{
        width: 24px;
        position: absolute;
        height: 1px;
        background-color: #000;
        top: 0;
        left: 0;
        content: '';
        z-index: 2;
        transition: all 300ms linear;
    }
    .navbar-light .navbar-toggler-icon:after{
        top: 8px;
    }
    .main-navbar .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon:after {
        transform: rotate(45deg);
    }
    .main-navbar .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon:before {
        transform: translateY(8px) rotate(-45deg);
    }
    .main-navbar  .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
        border-color: transparent;
    }
    .main-navbar .nav-link{
        color: #212121 !important;
        font-weight: 500;
        transition: all 200ms linear;
    }
    .main-navbar .nav-item:hover .nav-link{
        color: #ff7c00 !important;
    }
    .main-navbar .nav-item.active .nav-link{
        color: #777 !important;
    }
    .main-navbar .nav-link {
        position: relative;
        padding: 5px 0 !important;
        display: inline-block;
        font-size: 13px;
        font-weight: normal!important;
    }
    .main-navbar .nav-item:after{
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        content: '';
        background-color: #ff7c00;
        opacity: 0;
        transition: all 200ms linear;
    }
    .main-navbar .nav-item:hover:after{
        bottom: 0;
        opacity: 1;
    }
    .main-navbar .nav-item.active:hover:after{
        opacity: 0;
    }
    .main-navbar .nav-item{
        position: relative;
        transition: all 200ms linear;
    }

    /* #Primary style
    ================================================== */

    .bg-light {
        background-color: #fff !important;
        transition: all 200ms linear;
    }
    .section {
        position: relative;
        width: 100%;
        display: block;
    }
    .full-height {
        height: 100vh;
    }
    .over-hide {
        overflow: hidden;
    }
    .absolute-center {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        margin-top: 40px;
        transform: translateY(-50%);
        z-index: 20;
    }

    @media (max-width: 767px) { 
        /*        h1{
                    font-size: 38px;
                }*/
        .main-navbar .nav-item:after{
            display: none;
        }
        .main-navbar .nav-item::before {
            position: absolute;
            display: block;
            top: 15px;
            left: 0;
            width: 11px;
            height: 1px;
            content: "";
            border: none;
            background-color: #000;
            vertical-align: 0;
        }
        .main-navbar .dropdown-toggle::after {
            position: absolute;
            display: block;
            top: 10px;
            left: -23px;
            width: 1px;
            height: 11px;
            content: "";
            border: none;
            background-color: #000;
            vertical-align: 0;
            transition: all 200ms linear;
        }
        .main-navbar .dropdown-toggle[aria-expanded="true"]::after{
            transform: rotate(90deg);
            opacity: 0;
        }
        .main-navbar .dropdown-menu {
            padding: 0 !important;
            background-color: transparent;
            box-shadow: none;
            transition: all 200ms linear;
        }
        .main-navbar .dropdown-toggle[aria-expanded="true"] + .dropdown-menu {
            margin-top: 10px !important;
            margin-bottom: 20px !important;
        }
        body.dark .nav-item::before {
            background-color: #fff;
        }
        body.dark .dropdown-toggle::after {
            background-color: #fff;
        }
        body.dark .dropdown-menu {
            background-color: transparent;
            box-shadow: none;
        }
    }
    .switched {
        border-color: #000 !important;
        background: #ff7c00!important;
    }
    .switched #circle {
        left: 43px;
        box-shadow: 0 4px 4px rgba(26,53,71,0.25), 0 0 0 1px rgba(26,53,71,0.07);
        background: #fff;
    }
    .main-navbar .nav-item .dropdown-menu {
        transform: translate3d(0, 10px, 0);
        visibility: hidden;
        opacity: 0;
        max-height: 0;
        display: block;
        padding: 0;
        margin: 0;
        transition: all 200ms linear;
    }
    .main-navbar .nav-item.show .dropdown-menu {
        opacity: 1;
        visibility: visible;
        max-height: 999px;
        transform: translate3d(0, 0px, 0);
        width: auto!important;
    }
    .main-navbar .dropdown-menu {
        padding: 10px!important;
        margin: 0;
        font-size: 13px;
        letter-spacing: 1px;
        color: #212121;
        background-color: #fcfaff;
        border: none;
        border-radius: 3px;
        box-shadow: 0 5px 10px 0 rgba(138, 155, 165, 0.15);
        transition: all 200ms linear;
    }
    .main-navbar .dropdown-toggle::after {
        display: none;
    }

    .main-navbar .dropdown-item {
        padding: 3px 15px;
        color: #212121;
        border-radius: 2px;
        transition: all 200ms linear;
    }
    .main-navbar .navbarIcon{
        display: inline-block;
        border-radius: 5px;
    }
    .main-navbar .searchFormConatiner{
        display: block;
        margin-top: -14px;
        position: relative;

    }
    .preview-item-content p{
        white-space: normal;
    }
    @media (max-width: 576px){
        .main-navbar .navbarIcon{
            display: none;
        }
        .main-navbar .searchFormConatiner{
            display: none;
        }
    }

</style>
@push('scripts')
<script>
    
</script>
@endpush
