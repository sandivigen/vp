@extends('layout.main')

@section('title', $heading)

<?php
    // Get users list
    $user = array();
    foreach($users as $key=>$value){
        $user[$value->id] = $value->name;
    }

    // Get comments count list
    $comment_count = array();
    foreach($comments as $key=>$value){
        if (!isset($comment_count[$value->category_item_id])){
            $comment_count[$value->category_item_id] = 1;
        } else {
            $comment_count[$value->category_item_id] += 1;
        }
    }
?>

{{ Debugbar::info($articles) }}





@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2><strong>Список статей</strong></h2>
        </div>
    </div>

    <div class="row">

        <div class="col-md-9">




            @if($articles)
                @foreach($articles as $article)

                    <div class="row blog-posts small post-item">
                        {{--<div class="col-sm-4 padding-none">--}}
                        <div class="post-image">
                            <a href="http://resume-wordpress-3.tw1.ru/2013/01/11/two-crazy-jumping-pitbikers/" class="post-thumbnail">
                                <img alt="" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">
                            </a>
                        </div>
                        {{--</div>--}}

                        {{--<div class="col-sm-8 padding-none">--}}
                        <article class="post-content">
                            <div class="post-info-container">
                                <div class="post-info">
                                    <i class="fa fa-book post-icon"></i>
                                    <h2><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></h2>
                                    <ul class="post-meta">
                                        <li class="meta-user"><i class="fa fa-user"></i><a href="/user/{{ $user[$article->user_id] }}">{{ $user[$article->user_id] }}</a></li>
                                        <li class="meta-date"><i class="fa fa-clock-o"></i>{{ $article->created_at->format('Y-m-d') }}</li>
                                        <li></li>
                                        <li class="meta-cat"><i class="fa fa-folder-open"></i><a href="http://resume-wordpress-3.tw1.ru/category/markup/" rel="category tag">Markup</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="entry-content">
                                <p>{{  str_limit($article->text, $limit = 240, $end = '...')}}</p>
                            </div>
                            <div class="bottom_tools">
                                <?php
                                if (!isset($comment_count[$article->id]))
                                    $comment_count[$article->id] = 0;
                                ?>
                                <a href="/articles/{{ $article->id }}/#article-comment-block" class="meta_comments f-left shape new-angle">{{$comment_count[$article->id] }} Comment</a>
                                <span class="hidden lk">Like</span>
                                <span class="hidden unlk">Unlike</span>
                                <a href="#" class="jm-post-like f-left shape new-angle" data-post_id="1178" title="Like"><i id="icon-unlike" class="fa fa-heart"></i>&nbsp;Like</a>
                                <a class="f-right more_btn shape new-angle" href="/articles/{{ $article->id }}">Читать далее</a>
                            </div>
                        </article>
                        {{--</div>--}}
                    </div>

                    <div class="panel">

                        @if(!Auth::guest())
                            @if(Auth::user()->id == $article->user_id)
                                <div class="panel-header_ _panel-controls panel-controls-article">
                                    <div class="control-btn">
                                        <a class="edit-item" href="/articles/{{ $article->id }}/edit?red=list">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
                                        {{ Form::button('<i class="icon-trash"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) }}

                                        {{--                                    {!! Form::submit('<i class="icon-trash"></i>', $attributes = ['class' => 'trash-item']) !!}--}}
                                        {!! Form::close() !!}
                                        {{--<a href="#" class="trash-item">--}}
                                        {{--<i class="icon-trash"></i>--}}
                                        {{--</a>--}}
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="panel-content">

                            <div class="row">
                                <div class="col-md-2">
                                    <img class="img-rounded" style="width:100%" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">
                                </div>
                                <div class="col-md-10">
                                    <h4><strong><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></strong></h4>
                                    <a href="/user/{{ $user[$article->user_id] }}"><span class="glyphicon glyphicon-user custom-user-icon"></span>{{ $user[$article->user_id] }}</a>
                                    <span class="custom-calendar-icon"><i class="fa fa-calendar"></i>{{ $article->created_at->format('Y-m-d') }}</span>
                                    <a class="custom-comment-icon-a" href="/articles/{{ $article->id }}/#article-comment-block">
                                        <?php
                                        if (!isset($comment_count[$article->id]))
                                            $comment_count[$article->id] = 0;
                                        ?>
                                        <span class="custom-comment-icon"><i class="fa fa-comment"></i>{{$comment_count[$article->id] }}</span>
                                    </a>
                                    <p>
                                        {{  str_limit($article->text, $limit = 270, $end = '...')}}
                                        <a href="/articles/{{ $article->id }}">Читать статью</a>
                                    </p>

                                    <ul class="list-group">

                                        {{--<li class="list-group-item"><strong>category: </strong>--}}
                                        {{--<a href="/articles/category/{{ $article->category }}">{{ $article->category }}</a>--}}
                                        {{--</li>--}}

                                        {{--<span style="margin-right:10px;" class="pull-right label label-info">--}}
                                        {{--<span class="glyphicon glyphicon-comment"></span>--}}

                                        {{--0--}}

                                        {{--</span>--}}
                                        {{--<li class="list-group-item"><strong>tags: </strong>{{ $article->tags }}</li>--}}
                                    </ul>


                                </div>

                            </div>






                        </div>
                    </div>




                    <div style="clear: both"></div>


                @endforeach


            @else
                <p>No Article Found</p>
            @endif





        </div>

        <div class="col-md-3">
            <ul class="sidebar_widgets">
                <li class="widget w-recent-posts shape new-angle">
                    <h4 class="widget-head"><span class="main-color">Recent </span>Posts</h4>
                    <div class="widget-content">
                        <ul>
                            <li>
                                <div class="post-img">
                                    <a href="blog-single.html"><img src="assets/images/blog/small/1.jpg" alt=""></a>
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
                                    <a href="blog-single.html"><img src="assets/images/blog/small/2.jpg" alt=""></a>
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

<br>
<br>
<br>
<br>
<br>
<br>





    {{--<div class="row">--}}
        <div class="col-md-12">
            {!! $articles->render() !!}
        </div>
    {{--</div>--}}

@stop
