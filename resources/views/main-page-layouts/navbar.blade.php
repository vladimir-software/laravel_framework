<nav class="navbar navbar-expand  py-0 pr-0" id="main-navbar">
    <div class="logo_wrapper">  
        <div class="d-none d-md-block">
            <a href="{{url('/')}}"  class="logoForDesktop pl-4">
                <img class="normal  pt-2" src="{{asset('asset/connect_eo_new.png')}}" width="80px">
            </a>
        </div>
        <a href="{{url('/')}}" class=" d-md-none">
            <img class="normal" src="{{asset('home-style/connectEO_logo_orange.png')}}" alt="Logo" style="height: 47px!important;margin-top: 4px;">
        </a>                               
    </div>   
    <div class="navbar-collapse d-none d-md-block " id="navbarNav">
        <ul class="navbar-nav ml-auto  flex-row ">
            @if(isset(auth()->user()->id) && auth()->user()->id != '' && !empty(auth()->user()->approval))
            <li class="nav-item">
                <a class="goToSignup" href="{{route('home')}}">Dashboard</a>
            </li> 
            @elseif(isset(auth()->user()->approval))
            <li class="nav-item">
                <a class="goToSignup" href="{{route('FAQ')}}">Dashboard</a>
            </li> 
            @else
            <li class="nav-item active">               
                <a class="goToLogin" href="{{route('login')}}"><i class="fas fa-user"></i> Login</a>
            </li>
            <li class="nav-item">
                <a class="goToSignup" href="{{route('signup')}}">Start Free</a>
            </li>
            @endif
            <li class="nav-item navbars">                
                <a class="clickMe" href="javascript:void(0)">
                    <i class="fas fa-bars navbarBars"></i>
                </a>
            </li>

        </ul>
    </div>
</nav>
