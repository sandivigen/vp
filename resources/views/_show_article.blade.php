@extends('layout.main')

@section('title', $heading)

{{ \Carbon\Carbon::setLocale('ru') }}

{{--Debugbar::info($object);--}}

<?php
    // Get users list
    $user = array();
    foreach($users as $key=>$value){
        $user[$value->id]['name'] = $value->name;
        $user[$value->id]['avatar'] = $value->avatar;
    }
?>

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ $article->title }}</h3>
        </div>

        <p class="bg-danger">
            @foreach($errors->all() as $error)
                {{ $error }}
            @endforeach
        </p>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <img style="width:100%" src="/images/{{ $article->thumbnail }}">
                </div>
                <div class="col-md-8">
                    <h3>Item Description</h3>
                    <p>{{ $article->text }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h3>Data column 1</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>user_id: </strong>{{ $user[$article->user_id]['name'] }}</li>
                        <li class="list-group-item"><strong>category: </strong>{{ $article->category }}</li>
                        <li class="list-group-item"><strong>tags: </strong>{{ $article->tags }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h3>Data column 2</h3>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>video_id: </strong>{{ $article->video_id }}</li>
                        <li class="list-group-item"><strong>start_video: </strong>{{ $article->start_video }}</li>
                    </ul>
                </div>
            </div>
            @if(!Auth::guest())
                @if(Auth::user()->id == $article->user_id)
                    <div class="pull-right article-controls">
                        <a href="/articles/{{ $article->id }}/edit" class="btn btn-default">Edit</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
                            {!! Form::submit('Delete', $attributes = ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </div>

                @endif
            @endif

        </div>
    </div>



    {{--Блок комментариев--}}
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h3>Комментарии</h3>
            </div>
        </div>

        @foreach($article_comment as $comment)
            @if($comment->article_id == $article->id)
                <div class="row">

                    <div class="col-sm-1">
                        <div class="thumbnail">
                            {{--If an unauthorized user--}}
                            @if($comment['user_id'] == 0)
                                    <img class="img-responsive user-photo" src="/uploads/avatars/{{ $user[$comment->user_id]['avatar'] }}" >
                            @else
                                <a href="/user/{{ $user[$comment->user_id]['name'] }}">
                                    <img class="img-responsive user-photo" src="/uploads/avatars/{{ $user[$comment->user_id]['avatar'] }}" >
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-8">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{--If an unauthorized user--}}
                                @if($comment['user_id'] == 0)
                                    <strong><span>{{ $user[$comment->user_id]['name'] }}</span></strong>
                                @else
                                    <strong><a href="/user/{{ $user[$comment->user_id]['name'] }}">{{ $user[$comment->user_id]['name'] }}</a></strong>
                                @endif
                                <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="panel-body">
                                {{ $comment->comment_text }}
                                <hr>
                                <ul class="list-unstyled list-inline">
                                    <li>
                                        <button class="btn btn-xs btn-info" type="button" data-toggle="collapse" data-target="#view-comments-{{$article->id}}" aria-expanded="false" aria-controls="view-comments-{{$article->id}}">
                                            <i class="fa fa-comments-o"></i>
                                            Коментарии
                                        </button>
                                    </li>
                                    <li>
                                        {!! Form::open() !!}
                                        {!! Form::hidden('like_status', $article->id) !!}
                                        <button type="submit" class="btn btn-info btn-xs">
                                            <i class="fa fa-thumbs-up"></i>
                                            Нравится
                                            <span class="lake-count">3</span>
                                        </button>
                                        {!! Form::close() !!}
                                    </li>

                                    @if(!Auth::guest())
                                        @if(Auth::user()->id == $comment->user_id)
                                            <div class="pull-right article-controls">
                                                <a href="/comment/{{ $comment->id }}/edit" class="btn btn-default btn-xs">Edit</a>
{{--                                                {!! Form::open(['method' => 'DELETE', 'route' => ['articles.store', $comment->id]]) !!}--}}
{{--                                                {!! Form::open(array('action' => 'ArticlesCommentsController@destroy', 'enctype' => 'multipart/form-data', 'method' => 'DELETE')) !!}--}}
{{--                                                {!! Form::open(['method' => 'DELETE', 'action' => array('ArticlesCommentsController@delete', $comment->id)]) !!}--}}
{{--                                                {!! Form::open(array('action' => array('ArticlesCommentsController@destroy', $comment->id), 'method' => 'DELETE')) !!}--}}
                                                {!! Form::open(array('action' => ['ArticlesCommentsController@delete', $comment->id],'method' => 'DELETE')) !!}
                                                {!! Form::submit('Delete', $attributes = ['class' => 'btn btn-danger btn-xs']) !!}
                                                {!! Form::close() !!}
                                            </div>

                                        @endif
                                    @endif


                                </ul>
                            </div>



                            {{--Блок комментариев: ответы на коменты--}}
                            <div class="panel-footer clearfix">
                                <div class="collapse" id="view-comments-{{$article->id}}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <a href="/user/{{ $user[1]['name'] }}"><img style="height: 25px;" class="_img-responsive _user-photo" src="/uploads/avatars/{{ $user[1]['avatar'] }}" ></a>
                                                    <strong><a href="/user/{{ $user[1]['name'] }}">{{ $user[1]['name'] }}</a></strong>
                                                    <span class="text-muted">
                                                        commented 5 days ago
                                                        {{--{{ $comment->created_at->diffForHumans() }}--}}
                                                    </span>
                                                </div>
                                                <div class="panel-body">
                                                    Published text message.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Text message...">
                                          <span class="input-group-btn">
                                            <button class="btn btn-default" type="button">Send</button>
                                          </span>
                                        </div><!-- /input-group -->
                                    </div><!-- /.col-lg-6 -->
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @endif
        @endforeach
    </div>

    {{--Отправить комментарий--}}
    {!! Form::open(array('action' => 'ArticlesCommentsController@store', 'enctype' => 'multipart/form-data')) !!}
    <div class="form-group">
        {!! Form::textarea('comment_text', $value='Text your comment...', $attributes = ['class' => 'form-control', 'name' => 'comment_text', 'rows'=> 2]) !!}
    </div>
    {!! Form::hidden('article_id', $article->id) !!}
    {!! Form::submit('Add comment', $attributes = ['class' => 'btn btn-default']) !!}
    {!! Form::close() !!}

@stop