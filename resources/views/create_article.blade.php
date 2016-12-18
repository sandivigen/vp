@extends('layout.main')

@section('title', $heading)
@section('file_input', '
    <!-- File input -->
    <script src="/plugins/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="/plugins/fileinput/js/fileinput_locale_ru.js" type="text/javascript"></script>
    <link href="/plugins/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
')

@section('content')
    @if(Auth::guest())
        <p>Только зарегистрированные пользователи могут добавлять статьи. Зарегестрируйтесь или войдите в свою учетную запись.</p>
    @else







<br>
<br>
<br>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Форма добавления статьи</h3>
            </div>


            @if(count($errors) > 0)
                <br>
                <div class="col-sm-12 col-md-12">
                    @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                            ×</button>
                        <span class="glyphicon glyphicon-remove"></span>

                            {{ $error }}

                    </div>
                    @endforeach
                </div>
            @endif




            <div class="panel-body">

                {!! Form::open(array('action' => 'ArticlesController@store', 'enctype' => 'multipart/form-data')) !!}

                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    {!! Form::label('title', 'Заголовок статьи') !!}
                    {!! Form::text('title', $value=null, $attributes = ['class' => 'form-control', 'name' => 'title']) !!}
                </div>

                <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                    {!! Form::label('category', 'Категория') !!}
                    {!! Form::select('category', $value=array('' => 'Выбирите категорию', 'Workshop' => 'Мастерская', 'Biking' => 'Прогулки', 'Other' => 'Другое'), null, $attributes = ['class' => 'form-control', 'name' => 'category']) !!}<br>
                </div>

                <div class="kv-avatar center-block" style="width:200px">
                    <input id="avatar-1" name="avatar-1" type="file" class="file-loading">
                </div>

                {{--<div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">--}}
                    {{--{!! Form::label('category', 'Категория') !!}--}}
                    {{--<select class='form-control' name='category' required>--}}
                        {{--<option value="" disabled selected hidden>Пожалуйста сделайте выбор...</option>--}}
                        {{--<option value="Workshop">Мастерская</option>--}}
                        {{--<option value="Biking">Прогулки</option>--}}
                        {{--<option value="Other">Другое</option>--}}
                    {{--</select>--}}
                {{--</div>--}}




                <div class="form-group">
                    {!! Form::label('thumbnail', 'Миниатюра статьи') !!}
                    {!! Form::file('thumbnail', $attributes = ['class' => 'btn btn-default', 'name' => 'thumbnail']) !!}
                </div>

                <div class="form-group {{ $errors->has('text') ? 'has-error' : '' }}">
                    {!! Form::label('text', 'Текст статьи') !!}
                    {!! Form::textarea('text', $value=null, $attributes = ['class' => 'form-control', 'name' => 'text', 'rows'=>'6']) !!}
                </div>

                <div class="form-group {{ $errors->has('video_id') ? 'has-error' : '' }}">
                    {!! Form::label('video_id', 'ID видео') !!}
                    {!! Form::text('video_id', $value='i3Iek9FEkfA', $attributes = ['class' => 'form-control', 'name' => 'video_id']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('start_video', 'Начать показ видео с ') !!}
                    {!! Form::time('start_video', $value='00:00:00', $attributes = ['class' => 'form-control', 'name' => 'start_video', 'step' => '1']) !!}<br>
                </div>

                {{--<div class="form-group">--}}
                    {{--{!! Form::label('tags', 'Tags') !!}--}}
                    {{--{!! Form::text('tags', $value='tag1, tag2', $attributes = ['class' => 'form-control', 'name' => 'tags']) !!}--}}
                {{--</div>--}}

                {!! Form::submit('Опубликовать', $attributes = ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        @endif
    </div>



@stop