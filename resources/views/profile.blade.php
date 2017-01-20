@extends('layout.main')

@section('title', $heading)

@section('file_input', '
    <!-- File input image -->
    <script src="/plugins/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="/plugins/fileinput/js/fileinput_locale_ru.js" type="text/javascript"></script>
    <link href="/plugins/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
')

@section('content')
    @if (Auth::guest())
        <p>Вам необходимо авторизироваться, чтобы отредактировать профиль</p>
    @else
        @if(Auth::user()->id != $user->id)
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">Настройки профиля {{ $user->name }}</div>

                            <div class="panel-body">
                                <div class="wrapper-user-page">
                                    <div class="row">
                                        <div class="col-md-2">
                                            {{--<img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px;border-radius: 50%;margin-right: 25px;">--}}

                                            {!! Form::open(array('action' => ['UserController@profile'], 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                                            {{--<form enctype="multipart/form-data" action="/profile" method="POST">--}}
                                                {!! Form::file('avatar', $attributes = ['class' => 'btn btn-default', 'name' => 'avatar', 'id'=>'avatar-img']) !!}
        {{--                                    {{ Form::hidden('redirect', $redirect, ['name' => '_token']) }}--}}
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            {!! Form::submit('Сохранить', $attributes = ['class' => 'btn btn-custom']) !!}
                                            {!! Form::close() !!}

                                        </div>
                                        <div class="col-md-9">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- the fileinput plugin initialization -->
            <script>
                $("#avatar-img").fileinput({
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
        //            initialPreview: '<img src="/images/noimage.jpg" class="file-preview-image" title="" alt="" style="width:100%;height:auto;border-top-right-radius: 1.2em;">',
                    initialPreview: '<img src="/uploads/avatars/{{ $user->avatar }}" class="file-preview-image" title="" alt="" style="width:100%;height:auto;border-top-right-radius: 1.2em;">',
                    {{--initialPreviewConfig: [--}}
                            {{--{caption: "{{ $article->thumbnail }}"},--}}
                            {{--],--}}
                    layoutTemplates: {main2: '{preview} ' + '{browse}'},
                    allowedFileExtensions: ["jpg", "png", "gif"]
                });
            </script>
        @else
            <p>У вас нет прав для редактирования этого профиля</p>
        @endif
    @endif
@stop
