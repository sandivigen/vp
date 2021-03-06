@extends('layout.main')

@section('title', $heading)

{{--{{ Debugbar::info($comments) }}--}}
{{--{{ Debugbar::info($articles_all) }}--}}
@section('content')
    <div class="profile-page">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Профиль пользователя: {{ $user->name }}</div>

                    <div class="panel-body">
                        <div class="wrapper-user-page">
                            <div class="row user-page-top-block">
                                <div class="col-md-3">
                                    <img class="img-responsive profile-user-photo" src="/uploads/avatars/{{ $user->avatar }}" >
                                </div>
                                <div class="col-md-9">
                                    <ul class="list-group">
                                        <li class="list-group-item">Имя: {{ $user->name }}</li>
                                        <li class="list-group-item">Дата регистрации: {{ $user->created_at->format('Y-m-d') }}</li>
                                        <li class="list-group-item">Youtube канал: none</li>
                                        <li class="list-group-item">Всего статей: {{ $articles_count }}</li>
                                        <li class="list-group-item">Всего сообщений: {{ $comments_count }}</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row">

                                @if($user_articles)
                                    <section class="content">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">

                                                    <div>
                                                        <h3>
                                                            Последние статьи
                                                        </h3>
                                                    </div>

                                                    <div class="table-container">
                                                        <table class="table table-filter">
                                                            <tbody>
                                                            @foreach($user_articles as $article)
                                                                @if($article->publish == 1)
                                                                    <tr data-status="pagado">
                                                                        <td>
                                                                            <div class="media">
                                                                                <a href="/articles/{{ $article->id }}" class="pull-left">
                                                                                    <img src="/uploads/articles/{{ $article->id }}/{{ $article->thumbnail }}" class="media-photo">
                                                                                </a>
                                                                                <div class="media-body">
                                                                                    <span class="media-meta pull-right">{{ $article->created_at->format('Y-m-d') }}</span>

                                                                                    <h4 class="title">
                                                                                        <a href="/articles/{{ $article->id }}"> {{ $article->title }}</a>
                                                                                        @if(!Auth::guest())
                                                                                            @if(Auth::user()->id == $article->user_id)
                                                                                                <a href="/articles/{{ $article->id }}/edit?red=profile_page" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>
                                                                                                {!! Form::open(array('action' => ['ArticlesController@delete', $article->id], 'enctype' => 'multipart/form-data', 'class' => 'form-delete-userpage')) !!}

                                                                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteArticle-{{ $article->id }}"><em class="fa fa-trash"></em></button>

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
                                                                                        @php
                                                                                            $category_rus = ($article->category == 'News' ? 'Новости' : 'Без категории');
                                                                                        @endphp
                                                                                        <span class="media-meta pull-right">{{ $category_rus }}</span>
                                                                                    </h4>
                                                                                    <?php
                                                                                        // remove text formatting tags
                                                                                        $article_text =  strip_tags($article->text);
                                                                                    ?>
                                                                                    <p class="summary">{{ str_limit($article_text, $limit = 300, '...') }} <a href="/articles/{{ $article->id }}">Читать далее</a></p>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td align="center" class="comment-btn-block">
                                                                            <br>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <a href="/user/{{ $user->name }}/articles" class="btn btn-primary">Посмотреть все статьи  ({{ $articles_count }})</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @else
                                    <p>Пользователь пока не написал не одной статьи</p>
                                @endif
                            </div>

                            <div class="row">

                                @if($user_comments)

                                    <?php
                                        // Get article list
                                        $article_list = array();
                                        foreach($articles as $key=>$value){
                                            $article_list[$value->id] = $value->title;
                                        }
                                    ?>

                                    <section class="content">
                                        <div class="col-md-12">
                                            <div class="panel panel-default">
                                                <div class="panel-body">
                                                    <div>
                                                        <h3>
                                                            Последние комментарии
                                                        </h3>
                                                    </div>
                                                    <div class="table-container">
                                                        <table class="table table-filter">
                                                            <tbody>
                                                            @foreach($user_comments as $comment)
                                                                <tr data-status="pagado">
                                                                    <td>
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span class="media-meta pull-right">{{ $comment->created_at->format('Y-m-d') }}</span>
                                                                                <h4 class="title">
                                                                                    <a href="/articles/{{ $comment->category_item_id }}/#comment-id-{{ $comment->id }}"> {{ $article_list[$comment->category_item_id] }}</a>
                                                                                    {{--<span class="pull-right pagado">Like (0)</span>--}}
                                                                                    @if(!Auth::guest())
                                                                                        @if(Auth::user()->id == $comment->user_id)
                                                                                            {{--<a href="/comments/{{ $comment->id }}/edit?red=profile_page" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>--}}

                                                                                            {!! Form::open(array('action' => ['CommentsController@updatePopup', $comment->id], 'enctype' => 'multipart/form-data', 'class' => 'form-delete-userpage')) !!}
                                                                                                <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#updateComment-{{ $comment->id }}"><em class="fa fa-pencil"></em></button>
                                                                                                <!-- Modal -->
                                                                                                <div id="updateComment-{{ $comment->id }}" class="modal fade" role="dialog">
                                                                                                <div class="modal-dialog">
                                                                                                    <!-- Modal content-->
                                                                                                    <div class="modal-content">
                                                                                                        <div class="modal-header">
                                                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                            <h4 class="modal-title">Редактировать комментарий</h4>
                                                                                                        </div>
                                                                                                        <div class="modal-body">
                                                                                                            <textarea name="comment_text"  class="form-control" id="comment_text" cols="30" rows="4" >{{ $comment->comment_text }}</textarea>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <button type="submit" class="btn btn-primary" >Сохранить</button>
                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            {!! Form::close() !!}


                                                                                            {!! Form::open(array('action' => ['CommentsController@delete', $comment->id], 'enctype' => 'multipart/form-data', 'class' => 'form-delete-userpage')) !!}
                                                                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteComment-{{ $comment->id }}"><em class="fa fa-trash"></em></button>
                                                                                                <!-- Modal -->
                                                                                                <div id="deleteComment-{{ $comment->id }}" class="modal fade" role="dialog">
                                                                                                    <div class="modal-dialog">
                                                                                                        <!-- Modal content-->
                                                                                                        <div class="modal-content">
                                                                                                            <div class="modal-header">
                                                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                                <h4 class="modal-title">Вы точно хотите удалить комментарий?</h4>
                                                                                                            </div>
                                                                                                            <div class="modal-body">
                                                                                                                <p>"{{ $comment->comment_text }}"</p>
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
                                                                                </h4>
                                                                                <p class="summary">{{ $comment->comment_text }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <a href="/user/{{ $user->name }}/comments" class="btn btn-primary">Все комментарии пользователя ({{ $comments_count }})</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                @else
                                    <p>Пользователь не написал не одного комментария</p>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
