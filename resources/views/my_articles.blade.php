@extends('layout.main')

@section('title', $heading)

<?php $user = Auth::user(); ?>

@section('content')
    <a class="btn btn-primary fa fa-reply" href="/articles">All articles</a>
    <br><br>

    @if($articles)
        <div class="_panel _panel-default my-articles">

            <p class="bg-danger">
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </p>


            @foreach($articles as $article)
                @if($article->user_id == $user->id)

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img style="width:100%" src="/images/{{ $article->thumbnail }}">
                            </div>
                            <div class="col-md-9">
                                <h3><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></h3>
                                <p>{{ $article->text }}</p>
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Author: </strong>{{ $user->name }}</li>
                                    <li class="list-group-item"><strong>category: </strong>{{ $article->category }}</li>
                                    {{--<li class="list-group-item"><strong>tags: </strong>{{ $article->tags }}</li>--}}
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
                    <div style="clear: both"></div>
                    <hr>
                @endif
            @endforeach
        </div>


    @else
        <p>No Article Found</p>
    @endif
    Содержимое страницы
@stop
