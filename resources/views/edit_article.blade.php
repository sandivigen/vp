@extends('layout.main')

@section('title', $heading)
@section('file_input', '
    <!-- File input -->
    <script src="/plugins/fileinput/js/fileinput.min.js" type="text/javascript"></script>
    <script src="/plugins/fileinput/js/fileinput_locale_ru.js" type="text/javascript"></script>
    <link href="/plugins/fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Tinymce wysiwyg editor-->
    <script src="https://cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: "#mytextarea",
//            toolbar: "undo redo | styleselect | bold italic | link image",
        menubar: false,
//            menu: {
//                view: {title: "Happy", items: "code"}
//            },
//            plugins: "code",  // required by the code menu item
//            theme: "modern",
//      width: 800,
        height: 300,
//            plugins: [
//                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
//                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"",
//                "save table contextmenu directionality emoticons template paste textcolor"
//            ],
        plugins: [
            "advlist autolink link image lists charmap    anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code  insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons template paste textcolor"
        ],
//            content_css: "css/content.css",
        statusbar: false,
//            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons"
        toolbar: " undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image table | forecolor backcolor emoticons",

        language_url : "/plugins/tinymce/js/ru.js",  // site absolute URL
        language: "ru",
    });
    </script>

    <!-- Switchery toggle -->
    <link rel="stylesheet" href="/plugins/switchery/css/switchery.css" />
    <script src="/plugins/switchery/js/switchery.js"></script>
')




@section('content')


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



    <div class="row">

        <div class="col-md-9">

            <div class="form-style-1 shape new-angle">

                <h3 class="">Редактировать статью</h3>


                @if (Auth::guest())
                    <div class="panel-body radius-left-bottom"><p>Авторизируйтесь, чтобы отредактировать статью</p></div>
                @else
                    @if(Auth::user()->id == $article->user_id)
                        <div class="panel-body">
                            <div id="block-errors"></div>
                            {!! Form::open(array('action' => ['ArticlesController@update', $article->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}

                            <div class="row">
                                <div class="col-md-3">


                                    <div class="form-group">
                                        {!! Form::label('thumbnail', 'Миниатюра') !!}
                                        {!! Form::file('thumbnail', $attributes = ['class' => 'btn btn-default', 'name' => 'thumbnail', 'id'=>'avatar-1']) !!}
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Заголовок') !!}
                                        {!! Form::text('title', $value = $article->title, $attributes = ['class' => 'form-control top-style', 'name' => 'title']) !!}
                                    </div>
                                    {{--<div class="form-group">--}}
                                    {{--{!! Form::label('category', 'Категория') !!}--}}
                                    {{--{!! Form::select('category', $value = array('Workshop' => 'Workshop', 'Biking' => 'Biking', 'Other' => 'Other'), $article->category, $attributes = ['class' => 'form-control', 'name' => 'category']) !!}<br>--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group">--}}
                                    {{--{!! Form::label('js-switch', 'Добавить видео к статье') !!}--}}
                                    {{--<input type="checkbox" class="js-switch" checked />--}}
                                    {{--</div>--}}

                                    <div class="video-toggle-wrapper">
                                        <div class="form-group video-toggle">
                                            {!! Form::label('video_id', 'Видео id') !!}
                                            {!! Form::text('video_id', $value = $article->video_id, $attributes = ['class' => 'form-control mid-style', 'name' => 'video_id']) !!}
                                        </div>
                                        <div class="form-group video-toggle">
                                            {!! Form::label('start_video', 'Время начала показа видео') !!}
                                            {!! Form::time('start_video', $value = $article->start_video, $attributes = ['class' => 'form-control bot-style', 'name' => 'start_video',  'step' => '1']) !!}<br>
                                        </div>
                                    </div>

                                </div>
                            </div>






                            <div class="form-group">
                                {!! Form::label('text', 'Текст статьи') !!}
                                {!! Form::textarea('text', $value = $article->text, $attributes = ['class' => 'form-control mytextarea', 'id' => 'mytextarea', 'name' => 'text']) !!}
                            </div>



                            {{--<div class="form-group">--}}
                            {{--{!! Form::label('tags', 'Tags') !!}--}}
                            {{--{!! Form::text('tags', $value = $article->tags, $attributes = ['class' => 'form-control', 'name' => 'tags']) !!}--}}
                            {{--</div>--}}

                            {{ Form::hidden('redirect', $redirect, ['id' => 'redirect']) }}
                            {!! Form::submit('Сохранить', $attributes = ['class' => 'btn btn-custom']) !!}
                            {!! Form::close() !!}
                        </div>
                    @else
                        <div class="panel-body radius-left-bottom"><p>У вас нет прав редактировать эту статью</p></div>
                    @endif

                @endif


            </div>

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


    <!-- the fileinput plugin initialization -->
    <script>

        $("#avatar-1").fileinput({
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
            initialPreview: '<img src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}" class="file-preview-image" title="{{ $article->thumbnail }}" alt="{{ $article->thumbnail }}" style="width:100%;height:auto;border-top-right-radius: 1.2em;">',
            initialPreviewConfig: [
                {caption: "{{ $article->thumbnail }}"},
               ],
            layoutTemplates: {main2: '{preview} ' + '{browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"]
        });
    </script>

    <script>
//        var elem = document.querySelector(".js-switch");
//        var init = new Switchery(elem, {
//            color: '#7c8bc7',
//            jackColor: '#9decff',
//            size: 'small',
//            speed: '0.4s'
//        });
//
//        $( ".switchery" ).click(function() {
//            $( ".video-toggle-wrapper" ).slideToggle( "slow", function() {
//                // Animation complete.
//                $( "#video_id" ).val("");
//                $( "#start_video" ).val("00:00:00");
//            });
//        });

    </script>

@stop