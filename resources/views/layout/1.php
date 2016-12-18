
.post-item .post-content {
background: #f5f5f5;
}
.sidebar_widgets li.widget {
background: #f5f5f5;
}
.widget:not(.widget_tag_cloud):not(.widget_product_tag_cloud) .widget-content ul li, .related-posts ul li {
border-top: 1px #E4E4E4 solid;
}
body, .footer-top div.tweets .slick-prev:hover, .footer-top div.tweets .slick-next:hover, .top-head, .top-nav ul li ul, .cart-box, .top-head.sticky-nav, .page-title.title-4 .breadcrumbs, .icon-box:hover h3.bottom_half_border:after, .add-items i:hover, .tabs li.active a, .tabs li.active a:before, .tabs nav li:first-child.active a, .content-wrap section, .pagination ul li:hover, .pricing-tbl.style-4, .pricing-tbl.style-4 .plan-head i, .toolsBar select, .white-bg, .pagination.bar-1 ul, .pagination.bar-2 ul, .pager-slider, .header-left, .header-right, .conact_center_form, .bottom_tools a, .timeline .post-item:nth-child(even) .timeline_date .inner_date:before, .inner-menu ul ul, .top-bar li ul, .bordered-ul > li:hover, .shop-main-menu .woocommerce > ul > li > ul, .pricing-tbl, .pageWrapper.boxed, .top-nav ul li ul, .top-cart .cart-box, .top-head.sticky-nav, .header-9 .top-nav > ul > li:not(.megamenu):after, .header-9 .top-nav > ul > li.megamenu > span:after

<div class="topbar">
    <div class="header-left">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
            <strong class="style-logo" >Veloportal</strong>
        </div>

        {{--<strong class="style-logo" >Veloportal</strong>--}}

        <div class="topnav">

            <ul class="nav nav-left-custom collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <li><a href="/">Главная</a></li>
                <li><a href="/accessories"><span>Аксессуары</span></a></li>
                <li><a href="/articles"><span>Статьи</span></a></li>
                <li><a href="/articles"><span>Форум</span></a></li>
                <li><a href="/articles"><span>Новости</span></a></li>

                @if(!Auth::guest())
                {{--<li><a href="/my_articles">My articles</a></li>--}}
                {{--<li><a href="/comments">comments</a></li>--}}
                {{--<li><a href="/articles/32">32</a></li>--}}
                @endif
            </ul>
        </div>
    </div>
    <div class="header-right">
        <ul class="header-menu nav navbar-nav">
            @if (Auth::guest())


            <li class="dropdown" id="language-header">
                <a href="{{ url('/login') }}" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-login"></i>
                    <span>login</span>
                </a>
            </li> <li class="dropdown" id="language-header">
                <a href="{{ url('/register') }}" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-rocket"></i>
                    <span>Register</span>
                </a>
            </li>

            @else
            <li class="dropdown" id="messages-header">
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                    <i class="icon-doc"></i>
                <span class="badge_ badge-primary_ badge-header">
                <i class="icon-plus"></i>
                </span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-header clearfix">
                        <p class="pull-left">Добавить на сайт</p>
                    </li>
                    <li>
                        <ul class="dropdown-menu-list withScroll mCustomScrollbar _mCS_59" data-height="220" style="height: 220px;"><div class="mCustomScrollBox mCS-light" id="mCSB_59" style="position:relative; height:100%; overflow:hidden; max-width:100%;"><div class="mCSB_container mCS_no_scrollbar" style="position:relative; top:0;">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-file-text p-r-10 f-18 c-orange"></i>
                                            Статью
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-star p-r-10 f-18 c-red"></i>
                                            Аксессуар
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



            <!-- BEGIN USER DROPDOWN -->
            <li class="dropdown" id="user-header">
                {{--                    <a href="/user/{{ Auth::user()->name }} data-toggle="dropdown" data-hover="dropdown" data-close-others="true">--}}
                <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="true">
                    {{--<img src="" class="avatar-dashboard">--}}
                    <img src="/uploads/avatars/{{ Auth::user()->avatar }}" alt="user image">
                    <span class="username">Hi, {{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/user', Auth::user()->name) }}/comments"><i class="icon-user"></i><span>Comments list</span></a></li>
                    <li><a href="{{ url('/user', Auth::user()->name) }}/articles"><i class="icon-user"></i><span>Articles list</span></a></li>
                    <li><a href="{{ url('/profile') }}"><i class="icon-user"></i><span>Avatar</span></a></li>
                    <li><a href="{{ url('/logout') }}"><i class="icon-logout"></i><span>Logout</span></a></li>
                </ul>
            </li>
            <!-- END USER DROPDOWN -->
            @endif


        </ul>
    </div>
    <!-- header-right -->
</div>
