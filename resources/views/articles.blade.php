@extends('layout.main')

@section('title', $heading)

<?php
    // Get users list
    $user = array();
    foreach($users as $key=>$value){
        $user[$value->id] = $value->name;
    }

    // amount of comments for the article metadata
    $comment_count = array(); // amount of comments
    foreach($comments as $key=>$value){
        if ($value->publish == 1) { // если сообщение не опубликованно, то не будем его указывать в сумме
            if (!isset($comment_count[$value->category_item_id])){ // если не создан элемент массива, то создаем
                $comment_count[$value->category_item_id] = 1;
            } else {
                $comment_count[$value->category_item_id] += 1;
            }
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
                            <a href="/articles/{{ $article->id }}" class="post-thumbnail">
                                <img alt="" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">
                            </a>
                        </div>
                        {{--</div>--}}

                        {{--<div class="col-sm-8 padding-none">--}}
                        <article class="post-content">
                            <div class="post-info-container">
                                <div class="post-info">
                                    <i class="fa fa-video-camera post-icon"></i>
                                    <h2><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></h2>
                                    <ul class="post-meta">
                                        <li class="meta-user"><i class="fa fa-user"></i><a href="/user/{{ $user[$article->user_id] }}">{{ $user[$article->user_id] }}</a></li>
                                        <li class="meta-date"><i class="fa fa-clock-o"></i>{{ $article->created_at->format('Y-m-d') }}</li>
                                        @php
                                            $category_rus = ($article->category == 'News' ? 'Новости' : 'Без категории');
                                        @endphp
                                        <li class="meta-cat"><i class="fa fa-folder-open"></i><a href="/articles/category/{{ $article->category }}" rel="category tag">{{ $category_rus }}</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="entry-content">
                                <?php
                                    // remove text formatting html tags
                                    $article_text =  strip_tags($article->text);
                                ?>
                                <p>{!! str_limit($article_text, $limit = 240, $end = '...') !!}</p>
                            </div>
                            <div class="bottom_tools">
                                <?php
                                if (!isset($comment_count[$article->id]))
                                    $comment_count[$article->id] = 0;
                                ?>
                                <a href="/articles/{{ $article->id }}/#article-comment-block" class="meta_comments f-left shape new-angle button-comment">{{$comment_count[$article->id] }} <i class="glyphicon glyphicon-comment"></i></a>
                                <a href="#" class="jm-post-like f-left shape new-angle button-like" title="Like">0 <i id="icon-unlike" class="fa fa-heart"></i></a>
                                <a class="f-right more_btn shape new-angle button-read-more" href="/articles/{{ $article->id }}">Читать далее</a>
                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $article->user_id)
                                        <a class="f-right more_btn shape new-angle button-edit" href="/articles/{{ $article->id }}/edit?red=list"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
{{--                                                                                        {{ Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) }}--}}
                                        {!! Form::close() !!}

                                    @endif
                                @endif
                            </div>
                        </article>
                        {{--</div>--}}
                    </div>

                    <div style="clear: both"></div>

                @endforeach
            @else
                <p>Статьи не найдены</p>
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






    {{--<div class="row">--}}
        <div class="col-md-12">
            {!! $articles->render() !!}
        </div>
    {{--</div>--}}

@stop
