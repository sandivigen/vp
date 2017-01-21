@extends('layout.main')

@section('title', $heading)

@section('content')
    @if(!Auth::guest())
        @if(Auth::user()->role == 1)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit article</h3>
                </div>

                <p class="bg-danger">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </p>

                <div class="panel-body">
                    {!! Form::open(array('action' => ['CommentsController@update', $comment->id],  'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                    <div class="form-group">
                        {!! Form::label('comment_text', 'comment_text') !!}
                        {!! Form::textarea('comment_text', $value=$comment->comment_text, $attributes = ['class' => 'form-control', 'name' => 'comment_text', 'rows'=>'3']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user_id', 'user_id') !!}
                        {!! Form::text('user_id', $value=$comment->user_id, $attributes = ['class' => 'form-control', 'name' => 'user_id']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('guest_name', 'guest_name') !!}
                        {!! Form::text('guest_name', $value=$comment->guest_name, $attributes = ['class' => 'form-control', 'name' => 'guest_name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('type_category', 'type_category') !!}
                        {!! Form::text('type_category', $value=$comment->type_category, $attributes = ['class' => 'form-control', 'name' => 'type_category']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('category_item_id', 'category_item_id') !!}
                        {!! Form::text('category_item_id', $value=$comment->category_item_id, $attributes = ['class' => 'form-control', 'name' => 'category_item_id']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('publish', 'publish') !!}
                        {!! Form::text('publish', $value=$comment->publish, $attributes = ['class' => 'form-control', 'name' => 'publish']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('like', 'like') !!}
                        {!! Form::text('like', $value=$comment->like, $attributes = ['class' => 'form-control', 'name' => 'like']) !!}
                    </div>
                    {!! Form::submit('Edit', $attributes = ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        @else
            <p>У вас нет прав для просмотра данной страницы</p>
        @endif
    @else
        <p>У вас нет прав для просмотра данной страницы</p>
    @endif
@stop