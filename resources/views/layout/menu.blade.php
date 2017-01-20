{{--<nav class="navbar navbar-static-top navbar-inverse">--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-sm-12">--}}
                {{--<div class="navbar-header"><a href="/" class="navbar-brand" style="color:white">Veloportal</a></div>--}}
                {{--<ul class="nav navbar-nav">--}}
                    {{--<li><a href="/">Главная</a></li>--}}
                    {{--<li><a href="/accessories">Аксессуары</a></li>--}}
                    {{--<li><a href="/articles">Статьи</a></li>--}}
                    {{--<li><a href="/contact">Контакты</a></li>--}}

                    {{--@if(!Auth::guest())--}}
                        {{--<li><a href="/">||</a></li>--}}
                        {{--<li><a href="/my_articles">My articles</a></li>--}}
                        {{--<li><a href="/comments">comments</a></li>--}}
                        {{--<li><a href="/articles/32">32</a></li>--}}
                    {{--@endif--}}


                {{--</ul>--}}
                {{--<ul class="nav navbar-nav navbar-right">--}}
                    {{----}}
                    {{--<li><span class="navbar-text">Hello, Jason</span></li>--}}
                    {{--<li><a href="#">Logout</a></li>--}}
                {{--</ul>--}}

                {{--<ul class="nav navbar-nav navbar-right">--}}
                    {{--<li><a href="/accessories/create">+ Аксесс</a></li>--}}
                    {{--<li><a href="/articles/create">+ Статью</a></li>--}}
                    {{--<!-- Authentication Links -->--}}
                    {{--@if (Auth::guest())--}}
                        {{--<li><a href="{{ url('/login') }}">Login</a></li>--}}
                        {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                    {{--@else--}}
                        {{--<li class="dropdown">--}}
                            {{--<a href="/user/{{ Auth::user()->name }}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="position: relative; padding-left: 50px;">--}}
                                {{--<img src="/uploads/avatars/{{ Auth::user()->avatar }}" class="avatar-dashboard">--}}
                                {{--{{ Auth::user()->name }} <span class="caret"></span>--}}
                            {{--</a>--}}

                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li><a href="{{ url('/user', Auth::user()->name) }}/comments"><i class="fa fa-btn fa-user"></i> Comments list</a></li>--}}
                                {{--<li><a href="{{ url('/user', Auth::user()->name) }}/articles"><i class="fa fa-btn fa-user"></i> Articles list</a></li>--}}
                                {{--<li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i> Avatar</a></li>--}}
                                {{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i> Logout</a></li>--}}
                            {{--</ul>--}}
                        {{--</li>--}}
                    {{--@endif--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</nav>--}}





<nav class="navbar navbar-default vportal-navbar">

    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <div class="container-fluid">
                    <div class="navbar-header_">
                        <button type="button" class="navbar-toggle collapsed pull-left" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {{--<button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target=".navbar-ex2-collapse" style="padding: 8px 15px;"> <span class="sr-only">Toggle navigation</span>--}}
                            {{--<span aria-hidden="true" class="glyphicon glyphicon-sort"></span>--}}
                        {{--</button>--}}

                        <a class="navbar-brand" href="/">Veloportal</a>

                        <ul class="nav navbar-nav_ navbar-right pull-right login-block">
                            @if (Auth::guest())
                                <li class="login-block-guest"><a href="{{ url('/login') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> login</a></li>
                                <li class="login-block-guest"><a href="{{ url('/register') }}"><i class="fa fa-user-plus" aria-hidden="true"></i></i> Register</a></li>
                            @else
                                <li class="dropdown" id="user-header">
                                    <a href="#" data-toggle="dropdown" data-hover="dropdown" data-close-others="true" aria-expanded="true" class="user-block">
                                        <img src="/uploads/avatars/{{ Auth::user()->avatar }}" alt="user image" class="user-image">
                                        <span class="username">Hi, {{ Auth::user()->name }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-animate drop-menu-right">
                                        <li><a href="/articles/create"><i class="glyphicon glyphicon-plus"></i> Добавить статью</a></li>
                                        {{--<li><a href="#"><i class="fa fa-star"></i>Аксессуар</a></li>--}}
                                        <li><a href="{{ url('/user', Auth::user()->name) }}"><i class="glyphicon glyphicon-user"></i> Мой профиль</a></li>
                                        <li><a href="{{ url('/user', Auth::user()->name) }}/comments"><i class="glyphicon glyphicon-list"></i> Список комментариев</a></li>
                                        <li><a href="{{ url('/user', Auth::user()->name) }}/articles"><i class="glyphicon glyphicon-list"></i> Список статей</a></li>
                                        <li><a href="{{ url('/profile') }}"><i class="glyphicon glyphicon-cog"></i> Редактировать профиль</a></li>
                                        <li><a href="/articles_admin">Админ: статьи</a></li>
                                        <li><a href="/comments"><span>Админ: комменты</span></a></li>
                                        <li><a href="/admin_table_users"><span>Админ: пользователи</span></a></li>
                                        <li><a href="{{ url('/logout') }}">Выйти</a></li>
                                    </ul>
                                </li>
                            @endif
                        </ul>





                    <div class="collapse navbar-collapse pull-left" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li><a href="/">Главная</a></li>
                            <li><a href="/accessories"><span>Аксессуары</span></a></li>
                            <li><a href="/articles"><span>Статьи</span></a></li>
                            <li><a href="/articles"><span>Форум</span></a></li>
                            {{--<li><a href="/articles"><span>Новости</span></a></li>--}}

                            @if(!Auth::guest())
                                {{--<li><a href="/my_articles">My articles</a></li>--}}
                                {{--<li><a href="/comments">comments</a></li>--}}
                                {{--<li><a href="/articles/32">32</a></li>--}}
                            @endif
                        </ul>
                    </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

