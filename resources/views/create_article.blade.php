@extends('layout.main')

@section('title', $heading)

@section('file_input', '
    <!-- File input image -->
    <script src="/plugins/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="/plugins/fileinput/js/fileinput_locale_ru.js" type="text/javascript"></script>
    <link href="/plugins/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Switchery toggle -->
    <link rel="stylesheet" href="/plugins/switchery/css/switchery.css" />
    <script src="/plugins/switchery/js/switchery.js"></script>
')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="form-style-1 shape new-angle">
                <h3 class="">Добавить статью</h3>

                @if (Auth::guest())
                    <div class="row create-article-no-login">
                        <div class="col-md-12 ">
                            <div class="panel-body ">Только зарегистрированные пользователи могут добавлять статьи. Пожалуйста <a href="/register">зарегестрируйтесь</a> или <a href="/login">войдите</a> в свою учетную запись.</div>
                        </div>
                    </div>
                @else
                    <div class="panel-body">
                        {{-- Скрою вывод ошибок, пока вроде ошибки только валидации --}}
                        {{--@if(count($errors) > 0)--}}
                            {{--<div class="col-sm-12 col-md-12">--}}
                                {{--@foreach($errors->all() as $error)--}}
                                    {{--<div class="alert alert-danger">--}}
                                        {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
                                        {{--<span class="glyphicon glyphicon-remove"></span>--}}
                                        {{--{{ $error }}--}}
                                    {{--</div>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                        {{--@endif--}}
                        <div class="row">
                            {!! Form::open(array('action' => 'ArticlesController@store', 'enctype' => 'multipart/form-data')) !!}
                            <div class="col-md-3">
                                <div class="form-group">
                                    {!! Form::label('thumbnail', 'Миниатюра') !!}
                                    <div class="thumbnail-error-wrapper">
                                        {!! Form::file('thumbnail', $attributes = ['class' => 'btn btn-default', 'name' => 'thumbnail', 'id'=>'thumbnail-article']) !!}
                                    </div>
                                    {{-- for input file image --}}
                                    <div id="block-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    @if($errors->first('title'))
                                        <div class="triangle-error"><span class="glyphicon glyphicon-info-sign"></span> {{ $errors->first('title') }}</div>
                                    @endif
                                    {!! Form::label('title', 'Заголовок') !!}
                                    {!! Form::text('title', $value = '', $attributes = ['class' => 'form-control top-style', 'name' => 'title']) !!}
                                </div>
                                <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                                    {!! Form::label('category', 'Категория') !!}
                                    {!! Form::select('category', $value = array('News' => 'Новости', 'None' => 'Нет категории'), $value ='0', $attributes = ['class' => 'form-control', 'name' => 'category']) !!}<br>
                                </div>
                                {{--удалить video-toggle-wrapper, это я делал чтобы при нажатии выдавал с наала или нет показывать--}}
                                <div class="video-toggle-wrapper">
                                    <div class="form-group video-toggle">
                                        {!! Form::label('video_id', 'Видео id') !!}
                                        {!! Form::text('video_id', $value ='', $attributes = ['class' => 'form-control mid-style', 'name' => 'video_id']) !!}
                                    </div>
                                    <div class="form-group video-toggle">
                                        {!! Form::label('start_video', 'Время начала показа видео') !!}
                                        {!! Form::time('start_video', $value = '', $attributes = ['class' => 'form-control bot-style', 'name' => 'start_video',  'step' => '1']) !!}<br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('text') ? 'has-error-textarea' : '' }}">
                            @if($errors->first('text'))
                                <div class="triangle-error"><span class="glyphicon glyphicon-info-sign"></span> {{ $errors->first('text') }}</div>
                            @endif
                            {!! Form::label('text', 'Текст статьи') !!}
                            {!! Form::textarea('text', $value = '', $attributes = ['class' => 'form-control mytextarea', 'id' => 'mytextarea', 'name' => 'text']) !!}
                        </div>
                        {!! Form::submit('Опубликовать', $attributes = ['class' => 'btn btn-custom']) !!}
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- the fileinput plugin initialization -->
    <script>
        $("#thumbnail-article").fileinput({
            overwriteInitial: true,
            maxFileSize: 1500,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="glyphicon glyphicon-picture button-style-1"></i> Загрузить',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Cancel or reset changes',
            elErrorContainer: '#block-errors',
            msgErrorClass: 'alert alert-block alert-danger',
            initialPreview: '<img src="/images/noimage.jpg" class="file-preview-image" title="" alt="" style="width:100%;height:auto;border-top-right-radius: 1.2em;">',
            {{--initialPreviewConfig: [--}}
                {{--{caption: "{{ $article->thumbnail }}"},--}}
            {{--],--}}
            layoutTemplates: {main2: '{preview} ' + '{browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    </script>

    <!-- Tinymce wysiwyg editor-->
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "#mytextarea",
            menubar: false,
            height: 300,
            plugins: [
                "advlist autolink link image lists charmap    anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code  insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template paste textcolor"
            ],
            statusbar: false,
            toolbar: " undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image table ",
            language_url : "/plugins/tinymce/js/ru.js",  // site absolute URL
            language: "ru",
        });
    </script>
@stop