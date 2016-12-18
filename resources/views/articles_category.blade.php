@extends('layout.main')

@section('title', $heading)

<?php
foreach($users as $key=>$value){
    $user[$value->id] = $value->name;
}
?>

@section('content')
    <a class="btn btn-primary fa fa-reply" href="/articles">Back to articles</a>
    <br><br>
    @if($articles)
        @foreach($articles as $article)
            @if($article->category == $category)
                <div class="row">
                    <div class="col-md-2">
                        <img style="width:100%" src="/images/{{ $article->thumbnail }}">
                    </div>
                    <div class="col-md-10">
                        <h3><a href="/articles/{{ $article->id }}">{{ $article->title }}</a></h3>
                        <p>{{ $article->text }}</p>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Author: </strong>{{ $user[$article->user_id] }}</li>
                            <li class="list-group-item"><strong>category: </strong>{{ $article->category }}</li>
                            <li class="list-group-item"><strong>ID: </strong>{{ $article->id }}</li>
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
                <div style="clear: both"></div>
                <hr>
            @endif
        @endforeach

    @else
        <p>No Article Found</p>
    @endif

    <div class="row">
        <div class="col-md-12">
            {!! $articles->render() !!}
        </div>
    </div>

@stop
