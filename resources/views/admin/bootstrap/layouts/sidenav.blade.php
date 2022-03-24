

<!-- partial -->
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <div class="nav-link">
                <div class="profile-image">
                    <img id="admin-profile-image" src="/asset/noimage_person.png" alt="image">
                    <span class="online-status online"></span>
                </div>
                <div class="profile-name">
                    <p id="admin-name" class="name"></p>
                    <p id="admin-designation" class="designation"></p>
                </div>
            </div>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('bootstrap.admin-dashboard')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Dashboard</span>
                <span class="badge badge-success">New</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('users.user1')}}">
                <i class="fas fa-users" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Manage Users</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('users.edit-admin-users')}}">
                <i class="fas fa-user-lock" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Manage Admins</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('category.pages1')}}">
                <i class="fas fa-poll-h" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Manage Survey</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin.bootstrap.business.matching-matrix')}}">
                <i class="fas fa-equals" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Matching Matrix</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('category.service-category1')}}">
                <i class="fas fa-tasks" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Service Category</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('category.product-category1')}}">
                <i class="fas fa-tasks" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Product Category</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('category.product-industry1')}}">
                <i class="fas fa-industry" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Industry</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('messages')}}">
                <i class="far fa-envelope" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Messages</span>
            </a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{route('bootstrap.FAQs')}}">
                <i class="fas fa-question-circle" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">FAQ</span>
            </a>
        </li>       
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin.bootstrap.manage_home')}}">
                <i class="fas fa-home" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Manage Home</span>
            </a>
        </li>       
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin.bootstrap.ad_management')}}">
                <i class="fas fa-ad" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Ad Management</span>
            </a>
        </li>       
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin.bootstrap.subscriptions')}}">
                <i class="fas fa-money-check-alt" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Subscriptions</span>
            </a>
        </li>       
        <li class="nav-item active">
            <a class="nav-link" href="{{route('admin.bootstrap.manage_promo.platinum-promo')}}">
                <i class="fas fa-certificate" style="margin-right: 1.25rem;"></i>
                <span class="menu-title">Platinum Promo</span>
            </a>
        </li>    
        <li class="nav-item active d-md-none">
            <a class="nav-link" href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt" style="margin-right: 1.25rem;"></i>
                Log Out
            </a>                   
            <form id="logout-form" action="{{  route('admin.logout')  }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>

    </ul>
</nav>
<!-- partial -->
