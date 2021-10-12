<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        <a href="{{ url('') }}" class="logo"><span>{{ config('app.name', 'Laravel Project') }}<span></span></span><i class="mdi mdi-cube"></i></a>
        <!-- Image logo -->
        <!--<a href="{{ url('') }}" class="logo">-->
            <!--<span>-->
                <!--<img src="core/images/logo.png" alt="" height="30">-->
        <!--</span>-->
        <!--<i>-->
            <!--<img src="core/images/logo_sm.png" alt="" height="28">-->
        <!--</i>-->
        <!--</a>-->
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">

            <!-- Navbar-left -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>   
            </ul>

            <!-- Right(Notification) -->
            <ul class="nav navbar-nav navbar-right">

                <li class="list-notification hidden">
                    <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                        <i class="mdi mdi-bell"></i>
                        <span class="badge up bg-primary text-unread">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list" id="list-notification"></ul>
                </li>

                <li class="dropdown user-box">
                    <a href="" class="dropdown-toggle waves-effect waves-light user-link" data-toggle="dropdown" aria-expanded="true">
                        <img src="{{ \App\Helpers\UserHelper::getProfileImage() }}" alt="user-img" class="img-circle user-img">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                        <li>
                            <h5>{{ \App\Helpers\UserHelper::getRealName() }}</h5>
                        </li>
                        <li><a href="{{ route('profiles.index') }}"><i class="ti-user m-r-5"></i> Profile</a></li>
                        <li><a href="{{ route('companies.index') }}"><i class="ti-settings m-r-5"></i> Settings</a></li>
                        <li><a href="{{ route('logout') }}" class="btn-logout"><i class="ti-power-off m-r-5"></i> Logout</a></li>
                    </ul>
                </li>



            </ul> <!-- end navbar-right -->

        </div><!-- end container -->
    </div><!-- end navbar -->
</div>