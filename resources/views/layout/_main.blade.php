<!DOCTYPE html>
<html>
<head>
    <title>Veloportal - @yield('title')</title>

    <link rel="shortcut icon" href="/favicon2.png" type="image/x-icon">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/style2.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <link href='https://fonts.googleapis.com/css?family=Kurale&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>

@include('layout.menu')

<div class="topbar">
    <div class="header-left">
        <div class="topnav">
            <a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
            <ul class="nav nav-icons">
                <li><a href="#" class="toggle-sidebar-top"><span class="icon-user-following"></span></a></li>
                <li><a href="mailbox.html"><span class="octicon octicon-mail-read"></span></a></li>
                <li><a href="#"><span class="octicon octicon-flame"></span></a></li>
                <li><a href="builder-page.html"><span class="octicon octicon-rocket"></span></a></li>
            </ul>
        </div>
    </div>
    <div class="header-right">
        <ul class="header-menu nav navbar-nav">
            <!-- BEGIN USER DROPDOWN -->
            <li class="dropdown" id="language-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-globe"></i>
                    <span>Language</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#" data-lang="en"><img src="../assets/global/images/flags/usa.png" alt="flag-english"> <span>English</span></a>
                    </li>
                    <li>
                        <a href="#" data-lang="es"><img src="../assets/global/images/flags/spanish.png" alt="flag-english"> <span>Español</span></a>
                    </li>
                    <li>
                        <a href="#" data-lang="fr"><img src="../assets/global/images/flags/french.png" alt="flag-english"> <span>Français</span></a>
                    </li>
                </ul>
            </li>
            <!-- END USER DROPDOWN -->
            <!-- BEGIN NOTIFICATION DROPDOWN -->
            <li class="dropdown" id="notifications-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-bell"></i>
                    <span class="badge badge-danger badge-header">6</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header clearfix">
                        <p class="pull-left">12 Pending Notifications</p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list withScroll mCustomScrollbar _mCS_11" data-height="220" style="height: 220px;"><div class="mCustomScrollBox mCS-light" id="mCSB_11" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star p-r-10 f-18 c-orange"></i>
                                            Steve have rated your photo
                                            <span class="dropdown-time">Just now</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-heart p-r-10 f-18 c-red"></i>
                                            John added you to his favs
                                            <span class="dropdown-time">15 mins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-file-text p-r-10 f-18"></i>
                                            New document available
                                            <span class="dropdown-time">22 mins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-picture-o p-r-10 f-18 c-blue"></i>
                                            New picture added
                                            <span class="dropdown-time">40 mins</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-bell p-r-10 f-18 c-orange"></i>
                                            Meeting in 1 hour
                                            <span class="dropdown-time">1 hour</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-bell p-r-10 f-18"></i>
                                            Server 5 overloaded
                                            <span class="dropdown-time">2 hours</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-comment p-r-10 f-18 c-gray"></i>
                                            Bill comment your post
                                            <span class="dropdown-time">3 hours</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-picture-o p-r-10 f-18 c-blue"></i>
                                            New picture added
                                            <span class="dropdown-time">2 days</span>
                                        </a>
                                    </li>
                                </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></ul>
                    </li>
                    <li class="dropdown-footer clearfix">
                        <a href="#" class="pull-left">See all notifications</a>
                        <a href="#" class="pull-right">
                            <i class="icon-settings"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END NOTIFICATION DROPDOWN -->
            <!-- BEGIN MESSAGES DROPDOWN -->
            <li class="dropdown" id="messages-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-paper-plane"></i>
                <span class="badge badge-primary badge-header">
                8
                </span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header clearfix">
                        <p class="pull-left">
                            You have 8 Messages
                        </p>
                    </li>
                    <li class="dropdown-body">
                        <ul class="dropdown-menu-list withScroll mCustomScrollbar _mCS_12" data-height="220" style="height: 220px;"><div class="mCustomScrollBox mCS-light" id="mCSB_12" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">
                                    <li class="clearfix">
                        <span class="pull-left p-r-5">
                        <img src="../assets/global/images/avatars/avatar3.png" alt="avatar 3">
                        </span>
                                        <div class="clearfix">
                                            <div>
                                                <strong>Alexa Johnson</strong>
                                                <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time p-r-5"></span>12 mins ago
                                                </small>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                        <span class="pull-left p-r-5">
                        <img src="../assets/global/images/avatars/avatar4.png" alt="avatar 4">
                        </span>
                                        <div class="clearfix">
                                            <div>
                                                <strong>John Smith</strong>
                                                <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time p-r-5"></span>47 mins ago
                                                </small>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                        <span class="pull-left p-r-5">
                        <img src="../assets/global/images/avatars/avatar5.png" alt="avatar 5">
                        </span>
                                        <div class="clearfix">
                                            <div>
                                                <strong>Bobby Brown</strong>
                                                <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time p-r-5"></span>1 hour ago
                                                </small>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </li>
                                    <li class="clearfix">
                        <span class="pull-left p-r-5">
                        <img src="../assets/global/images/avatars/avatar6.png" alt="avatar 6">
                        </span>
                                        <div class="clearfix">
                                            <div>
                                                <strong>James Miller</strong>
                                                <small class="pull-right text-muted">
                                                    <span class="glyphicon glyphicon-time p-r-5"></span>2 days ago
                                                </small>
                                            </div>
                                            <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                        </div>
                                    </li>
                                </div><div class="mCSB_scrollTools" style="position: absolute; display: none;"><div class="mCSB_draggerContainer"><div class="mCSB_dragger" style="position: absolute; top: 0px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="position:relative;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></ul>
                    </li>
                    <li class="dropdown-footer clearfix">
                        <a href="mailbox.html" class="pull-left">See all messages</a>
                        <a href="#" class="pull-right">
                            <i class="icon-settings"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <!-- END MESSAGES DROPDOWN -->
            <!-- BEGIN USER DROPDOWN -->
            <li class="dropdown" id="user-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <img src="../assets/global/images/avatars/user1.png" alt="user image">
                    <span class="username">Hi, John Doe</span>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="icon-user"></i><span>My Profile</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-calendar"></i><span>My Calendar</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-settings"></i><span>Account Settings</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="icon-logout"></i><span>Logout</span></a>
                    </li>
                </ul>
            </li>
            <!-- END USER DROPDOWN -->
            <!-- CHAT BAR ICON -->
            <li id="quickview-toggle"><a href="#"><i class="icon-bubbles"></i></a></li>
        </ul>
    </div>
    <!-- header-right -->
</div>


<div class="container">



    @if(Session::has('message'))
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        ×</button>
                    <span class="glyphicon glyphicon-ok"></span> {{ Session::get('message') }}
                </div>
            </div>
        </div>
    @endif



    <div class="row">
        <div class="col-md-12">
            <h1>@yield('title')</h1>

            @yield('content')
        </div>
    </div>
</div>
<!-- JavaScripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="/js/main.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>

