@extends('layout.main')

{{--{{ $heading = $article->title }}--}}
@section('title', $heading)

{{ \Carbon\Carbon::setLocale('ru') }}

{{--{{ Debugbar::info($article_comment) }}--}}

<?php
    // Get users list
    $user = array();
    foreach($users as $key=>$value){
        $user[$value->id]['name'] = $value->name;
        $user[$value->id]['avatar'] = $value->avatar;
    }
?>





@section('content')


    <div class="bg-danger">
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
    </div>



    <div class="row">
        <div class="col-md-12">
            <h2><strong>Список статей</strong></h2>
        </div>
    </div>

    <div class="row">

        <div class="col-md-9">






                    <div class="row blog-posts small post-item">
                        <div class="post-image">
                            <a href="/articles/{{ $article->id }}" class="post-thumbnail">
                                <img alt="" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">
                            </a>
                        </div>

                        <article class="post-content">
                            <div class="post-info-container">
                                <div class="post-info">
                                    <i class="fa fa-video-camera post-icon"></i>
                                    <h2>{{ $article->title }}</h2>
                                    <ul class="post-meta">
                                        <li class="meta-user"><i class="fa fa-user"></i><a href="/user/{{ $user[$article->user_id]['name'] }}/comments">{{ $user[$article->user_id]['name'] }}</a></li>
                                        <li class="meta-date"><i class="fa fa-clock-o"></i>{{ $article->created_at->format('Y-m-d') }}</li>
                                        <li></li>
                                        <li class="meta-cat"><i class="fa fa-folder-open"></i><a href="/articles/category/{{ $article->category }}" rel="category tag">{{ $article->category }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="entry-content">
                                <p>{{ $article->text }}</p>

                            </div>
                            <div class="bottom_tools">
                                <?php
                                if (!isset($comment_count[$article->id]))
                                    $comment_count[$article->id] = 0;
                                ?>
                                <a href="#article-comment-block" class="meta_comments f-left shape new-angle button-comment">{{$comment_count[$article->id] }} <i class="glyphicon glyphicon-comment"></i></a>


                                <a href="#" class="jm-post-like f-left shape new-angle button-like" data-post_id="1178" title="Like">0 <i id="icon-unlike" class="fa fa-heart"></i></a>


                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $article->user_id)
                                        <a class="f-right more_btn shape new-angle button-edit" href="/articles/{{ $article->id }}/edit?red=list"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
                                        {{--                                            {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) }}--}}
                                        {!! Form::close() !!}

                                    @endif
                                @endif
                            </div>
                        </article>
                    </div>

        </div>

        <div class="col-md-3">
            <ul class="sidebar_widgets">
                <li class="widget w-recent-posts shape new-angle">
                    <h4 class="widget-head"><span class="main-color">Recent </span>Posts</h4>
                    <div class="widget-content">
                        <ul>
                            <li>
                                <div class="post-img">
                                    <a href="blog-single.html"><img alt="" style="width:40px;" src="/images/articles/1/thumb_bostonbikinglarge.jpg"></a>
                                </div>
                                <div class="widget-post-info">
                                    <h5><a href="blog-single.html">Blog post title with Image</a></h5>
                                    <div class="meta">
                                        <span><i class="fa fa-clock-o"></i>Dec 28, 2013,</span><a href="blog-single.html"><i class="fa fa-comments"></i>15</a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="post-img">
                                    <a href="blog-single.html"><img alt="" style="width:40px;" src="/images/articles/1/thumb_bostonbikinglarge.jpg"></a>
                                </div>
                                <div class="widget-post-info">
                                    <h5><a href="blog-single.html">Blog post title</a></h5>
                                    <div class="meta">
                                        <span><i class="fa fa-clock-o"></i>Dec 28, 2013,</span><a href="blog-single.html"><i class="fa fa-comments"></i>15</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>





    <div class="row page-app page-profil">
        <div class="col-lg-9 col-md-9">



            <div class="panel panel-default">
                <div class="panel-header">
                    <h3 class="panel-title">{{ $article->title }} </h3>
                </div>

                @if(!Auth::guest())
                    @if(Auth::user()->id == $article->user_id)

                        <div class="panel-controls-article">
                            <div class="control-btn">
                                <a class="edit-item" href="/articles/{{ $article->id }}/edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
                                {{ Form::button('<i class="icon-trash"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) }}

                                {{--                                    {!! Form::submit('<i class="icon-trash"></i>', $attributes = ['class' => 'trash-item']) !!}--}}
                                {!! Form::close() !!}

                            </div>
                        </div>

                    @endif
                @endif





                <div class="panel-content panel-content-article">
                    <div class="row">

                        {{--<div class="col-md-4">--}}
                            {{--<img style="width:100%" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">--}}
                        {{--</div>--}}
                        {{--<div class="col-md-8">--}}
                        <div class="col-md-12">

                            <a href="/user/{{ $user[$article->user_id]['name'] }}/comments"><span class="glyphicon glyphicon-user custom-user-icon"></span>{{ $user[$article->user_id]['name'] }}</a>

                            <span class="custom-calendar-icon"><i class="fa fa-calendar"></i>{{ $article->created_at->format('Y-m-d') }}</span>

                            <a class="custom-comment-icon-a" href="#article-comment-block">
                                <?php
                                if (!isset($comment_count[$article->id]))
                                    $comment_count[$article->id] = 0;
                                ?>
                                <span class="custom-comment-icon"><i class="fa fa-comment"></i>{{$comment_count[$article->id] }}</span>
                            </a>

                            <p>{{ $article->text }}</p>

                            <?php
                                // Star video amount seconds
                                $dt = new DateTime($article->start_video);
                                $start_video = (int)$dt->format('s') + 60 * (int)$dt->format('i') + 3600 * (int)$dt->format('H');
                            ?>

                            <iframe class="show-article-video" width="560" height="315"   src="https://www.youtube.com/embed/{{ $article->video_id }}?rel=0;start={{ $start_video }}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>

                    <br>
                    <br>


                </div>
            </div>

            @include('comments.list_comments_article')
            @include('comments.create_comment_article')


        </div>





        {{--// sidebar--}}
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs profil-right">

            <div class="profil-sidebar-element">
                <h3><strong>Автор статьи</strong></h3>
                <div class="sidebar-article-user">
                    <div class="row">
                        <div class="col-xs-4">
                            <img src="/uploads/avatars/1465394901.png" class="img-responsive">
                        </div>
                        <div class="col-xs-8">
                            <span class="sidebar-article-user-name"><strong><a href="/user/{{ $user[$article->user_id]['name'] }}/comments">{{ $user[$article->user_id]['name'] }}</a></strong></span>
                            <p class="sidebar-article-user-role">Пользователь</p>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <p class="m-t-0"><span class="c-primary"><strong>3</strong></span> Статьи</p>
            <p class="m-t-0"><span class="c-primary"><strong>8</strong></span> Сообщений</p>

            <hr>





        </div>
    </div>

@stop
