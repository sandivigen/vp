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
        <div class="col-md-9">

            <div class="row blog-posts small post-item single-post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-image">
                                {{--<img alt="" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">--}}
                            <?php
                            // Star video amount seconds
                            $dt = new DateTime($article->start_video);
                            $start_video = (int)$dt->format('s') + 60 * (int)$dt->format('i') + 3600 * (int)$dt->format('H');
                            ?>

                            <iframe class="show-article-video" width="560" height="315"   src="https://www.youtube.com/embed/{{ $article->video_id }}?rel=0;start={{ $start_video }}" frameborder="0" allowfullscreen></iframe>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
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
                                {!! $article->text !!}
                            </div>
                            @if(!Auth::guest())
                                @if(Auth::user()->id == $article->user_id)


                                            <a class="edit-item" href="/articles/{{ $article->id }}/edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
{{--                                            {{ Form::button('<i class="icon-trash"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) }}--}}
                                            {!! Form::close() !!}


                                @endif
                            @endif
                        </article>

                    </div>
                </div>
            </div>

            @include('comments.list_comments_article')
            @include('comments.create_comment_article')

        </div>



        <div class="col-md-3">
            <ul class="sidebar_widgets">
                <li class="widget w-recent-posts shape new-angle">
                    <h4 class="widget-head"><span class="main-color">Автор </span>Статьи</h4>
                    <div class="widget-content">
                        <ul>
                            <li>
                                <div class="post-img" style="float: left; margin-right: 10px;">
                                    <a href="blog-single.html"><img alt="" style="width:40px;" src="/uploads/avatars/1465394901.png"></a>
                                </div>
                                <div class="widget-post-info">
                                    <a href="/user/{{ $user[$article->user_id]['name'] }}/comments">{{ $user[$article->user_id]['name'] }}</a><br>
                                    <span>Пользователь</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>







@stop
