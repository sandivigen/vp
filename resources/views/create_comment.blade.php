@extends('layout.main')

@section('title', $heading)

@section('content')
    @if(!Auth::guest())
        @if(Auth::user()->role == 1)
            <div class="pull-left article-controls">
                <a class="btn btn-primary" href="/admin_table_comments"><i class="glyphicon glyphicon-list"> </i> Back to comments list</a>
            </div><br><br>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add article</h3>
                </div>

                <p class="bg-danger">
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </p>
                <div class="panel-body">

                    {!! Form::open(array('action' => 'CommentsController@store', 'enctype' => 'multipart/form-data')) !!}

                    <div class="form-group">
                        {!! Form::label('comment_text', 'comment_text') !!}
                        {!! Form::textarea('comment_text', $value='comment_text', $attributes = ['class' => 'form-control', 'name' => 'comment_text', 'rows'=>'3']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('user_id', 'user_id') !!}
                        {!! Form::text('user_id', $value='1', $attributes = ['class' => 'form-control', 'name' => 'user_id']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('guest_name', 'guest_name') !!}
                        {!! Form::text('guest_name', $value='guest_name', $attributes = ['class' => 'form-control', 'name' => 'guest_name']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('type_category', 'type_category') !!}
                        {!! Form::text('type_category', $value='article', $attributes = ['class' => 'form-control', 'name' => 'type_category']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('category_item_id', 'category_item_id') !!}
                        {!! Form::text('category_item_id', $value='32', $attributes = ['class' => 'form-control', 'name' => 'category_item_id']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('publish', 'publish') !!}
                        {!! Form::text('publish', $value='1', $attributes = ['class' => 'form-control', 'name' => 'publish']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('like', 'like') !!}
                        {!! Form::text('like', $value='0', $attributes = ['class' => 'form-control', 'name' => 'like']) !!}
                    </div>
                    {!! Form::submit('Add', $attributes = ['class' => 'btn btn-primary']) !!}
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