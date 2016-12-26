@extends('layout.main')

@section('title', $heading)

{{--{{ Debugbar::info($comments) }}--}}
{{--{{ Debugbar::info($articles_all) }}--}}
@section('content')
    <div class="container profile-page">
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
                                                                {{--                                                @if($user->id == $article->user_id)--}}
                                                                <tr data-status="pagado">
                                                                    <td>
                                                                        <div class="media">
                                                                            <a href="/articles/{{ $article->id }}" class="pull-left">
                                                                                <img src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}" class="media-photo">
                                                                            </a>
                                                                            <div class="media-body">
                                                                                <span class="media-meta pull-right">{{ $article->created_at->format('Y-m-d') }}</span>

                                                                                <h4 class="title">
                                                                                    <a href="/articles/{{ $article->id }}"> {{ $article->title }}</a>
                                                                                    @if(!Auth::guest())
                                                                                        @if(Auth::user()->id == $article->user_id)
                                                                                            <a href="/articles/{{ $article->id }}/edit?red=profile_page" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>
                                                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id], 'class' => 'form-delete-userpage']) !!}
                                                                                            <button type="submit" class="btn btn-danger btn-xs"><em class="fa fa-trash"></em></button>
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
                                                                {{--@endif--}}
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <a href="/user/{{ $user->name }}/articles" class="btn btn-primary">Посмотреть все статьи</a>

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
                                                            @foreach($user_comments as $user_comment)
                                                                {{--                                                    @if($user->id == $comment->user_id)--}}
                                                                <tr data-status="pagado">
                                                                    <td>
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <span class="media-meta pull-right">{{ $user_comment->created_at->format('Y-m-d') }}</span>
                                                                                <h4 class="title">
                                                                                    <a href="/articles/{{ $user_comment->category_item_id }}"> {{ $article_list[$user_comment->category_item_id] }}</a>
                                                                                    {{--<span class="pull-right pagado">Like (0)</span>--}}
                                                                                </h4>
                                                                                <p class="summary">{{ $user_comment->comment_text }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                {{--@endif--}}
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        <a href="/user/{{ $user->name }}/comments" class="btn btn-primary">Все комментарии пользователя</a>

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
