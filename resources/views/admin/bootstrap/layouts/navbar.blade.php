<!-- partial:partials/_navbar.html -->
<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{route('bootstrap.admin-dashboard')}}">
            <img src="{{asset('/bootstrap/asset/admin-ceo-logo.png')}}" class="w-100" style="height:auto!important"  alt="logo">
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{route('bootstrap.admin-dashboard')}}">
            <img src="{{asset('/asset/connect_eo.png')}}" alt="logo"></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav">
            <li class="nav-item dropdown d-none d-lg-flex">
                <a class="nav-link dropdown-toggle nav-btn" id="actionDropdown" href="javascript:void(0);" data-toggle="dropdown">
                    <span class="btn">+ Create new</span>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-left" aria-labelledby="actionDropdown">
                    <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-user text-primary"></i>
                        User Account
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/admin/add-admin-user">
                        <i class="icon-user-following text-warning"></i>
                        Admin User
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);">
                        <i class="icon-docs text-success"></i>
                        Sales report
                    </a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">   
            <li class="nav-item dropdown d-none d-lg-flex">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img id="admin-small-image" src="/asset/noimage_person.png" width="30px" height="30px;" style="border-radius:5px;">
                </a>
                <div class="dropdown-menu  navbar-dropdown dropdown-right">
                    <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt" style="font-size: 13px; color: #31b8f5;"></i>
                        Log Out
                    </a>                   
                    <form id="logout-form" action="{{  route('admin.logout')  }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>          

        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="icon-menu"></span>
        </button>
    </div>
</nav>
