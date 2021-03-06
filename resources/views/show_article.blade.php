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

    {{-- Если статья не удаленна, то показываем --}}
    @if($article->publish == 1)

        <div class="row">
            <div class="col-md-9">

                <div class="row blog-posts small post-item single-post" data-postid="{{ $article->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="post-image">
                                    {{--<img alt="" src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}">--}}
                                <?php
                                // Star video amount seconds
                                $dt = new DateTime($article->start_video);
                                $start_video = (int)$dt->format('s') + 60 * (int)$dt->format('i') + 3600 * (int)$dt->format('H');
                                ?>

                                {{--<iframe class="show-article-video" width="560" height="315"   src="https://www.youtube.com/embed/{{ $article->video_id }}?rel=0;start={{ $start_video }}" frameborder="0" allowfullscreen></iframe>--}}

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
                                            <li class="meta-user"><i class="fa fa-user"></i><a href="/user/{{ $user[$article->user_id]['name'] }}">{{ $user[$article->user_id]['name'] }}</a></li>
                                            <li class="meta-date"><i class="fa fa-clock-o"></i>{{ $article->created_at->format('Y-m-d') }}</li>
                                            <li></li>
                                            <li class="meta-cat"><i class="fa fa-folder-open"></i><a href="/articles/category/{{ $article->category }}" rel="category tag">{{ $article->category }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="entry-content">
                                    {!! $article->text !!}
                                </div>

                                <?php

                                    if ($likes_active)
                                        $likes_active_class = 'btn-primary';
                                    else
                                        $likes_active_class = 'btn-default';
                                ?>

                                <button id="add-like" class="btn {{ $likes_active_class }} pull-left" role="button" data-toggle="popover" title="" data-content="Только зарегистрированные пользователи могут голосовать, пожалуйста авторизируйтесь."><span class="badge" id="id-like-count">{{ $likes_count }}</span> <i class="glyphicon glyphicon-thumbs-up"></i> Like</button>


                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $article->user_id)

                                        <a href="/articles/{{ $article->id }}/edit" class="btn btn-primary pull-right" role="button"><i class="fa fa-edit"></i> Редактировать</a>

                                        {!! Form::open(array('action' => ['ArticlesController@delete', $article->id], 'enctype' => 'multipart/form-data', 'class' => 'form-delete-userpage pull-right')) !!}

                                        <button type="button" class="btn btn-danger pull-right article-delete-btn" data-toggle="modal" data-target="#deleteArticle-{{ $article->id }}"><em class="fa fa-trash"></em> Удалить статью</button>

                                        <!-- Modal -->
                                        <div id="deleteArticle-{{ $article->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Удалить статью</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Вы уверены что хотите удалить статью "{{ $article->title }}"?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" >Да</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
                                        <a href="blog-single.html"><img alt="" style="width:40px;" src="/uploads/avatars/{{ $user[$article->user_id]['avatar'] }}"></a>
                                    </div>
                                    <div class="widget-post-info">
                                        <a href="/user/{{ $user[$article->user_id]['name'] }}">{{ $user[$article->user_id]['name'] }}</a><br>
                                        <span>Пользователь</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="">
                                        <span>Комментарии</span>
                                        (<a href="/user/{{ $user[$article->user_id]['name'] }}/comments">{{ $comments_count }}</a>)<br>
                                    </div>
                                    <div class="">
                                        <span>Статьи</span>
                                        (<a href="/user/{{ $user[$article->user_id]['name'] }}/articles">{{ $articles_count }}</a>)<br>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <script>

            $(document).ready(function(){

                var postId = $('.single-post').attr('data-postid');
                var token = '{{ Session::token() }}';
                var url = '{{ route('edit') }}';
                $('#add-like').on('click', function(){


//                    $('#id-like-count').html(function(i, val) { return +val+1 });
                    $('#add-like').toggleClass('btn-default btn-primary');

                    if ($("#add-like").hasClass("btn-primary")) {
                        $('#id-like-count').text($('#id-like-count').text()*1+1);
                    }  else {
                        $('#id-like-count').text($('#id-like-count').text()*1-1);
                    }


                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: { text: $('#id-like-count').text(), post_id: postId, category_post_id: 1, _token: token}
                    })
                            .done(function(msg){
                                if (msg['action_status'] == 1) {
                                    $('[data-toggle="popover"]').popover({
                                        placement: 'top',
                                    }).popover('show');
                                    $('#id-like-count').text($('#id-like-count').text()*1-1);
                                    $('#add-like').toggleClass('btn-default btn-primary')
                                    setTimeout(function(){
                                        $('[data-toggle="popover"]').popover('destroy');
                                    }, 3000);
                                }
                                console.log(msg['action_status']);
//                                                        console.log(JSON.stringify(msg));
//                                                        console.log('tex');
                            });
                });

            });



            //                                    function getText(fileName) {
            //
            //                                        var req = getXmlHttp();
            //
            //                                        req.onreadystatechange = function () {
            //                                            if (req.readyState == 4){
            //                                                if (req.status != 200)
            //                                                    alert(req.status + ': '+req.statusText);
            //                                                else
            //                                                    alert(req.responseText);
            //                                            }
            //                                        };
            //
            //                                        req.open("GET", fileName, true);
            //
            //                                        req.send(null);
            //
            //                                    }


        </script>

    @else
        @if(!Auth::guest())
            @if($article->user_id == Auth::user()->id)
                Вы удалили эту статью, если вы хотите восстановить ее, то обратитесь к администратору info@veloportal.org
            @endif
        @else
            Данная статья удалена
        @endif
    @endif

@stop
