@extends('layout.main')

@section('title', $heading)

{{-- if user not exists--}}
@if($user_exists == 1)

    <?php


        // Get article list
        $article_list = array();
        foreach($articles as $key=>$value){
            $article_list[$value->id] = $value->title;
        }

    Debugbar::info($user);
    ?>


    @section('content')
        @if(Auth::guest())
            <p>Только зарегистрированные пользователи могут просматривать эту страницу. Зарегестрируйтесь или войдите в свою учетную запись.</p>
        @else
            <div class="row">

                @if($articles)
                    <section class="content">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php
                                    // amount of articles
                                    $count_articles = 0;
                                    foreach($articles as $article) {
                                        if($user->id == $article->user_id)
                                            $count_articles += 1;
                                    }
                                    ?>
                                    <div>
                                        <h3>
                                            {{--@if(Auth::user()->id == $user->id)--}}
                                                {{--Мои статьи ({{ $count_articles }})--}}
                                            {{--@else--}}
                                                Статьи пользователя {{ $user->name }} ({{ $count_articles }})
{{--                                                Статьи пользователя {{ $user->name }}--}}
                                            {{--@endif--}}
                                        </h3>
                                    </div>

                                    <div class="table-container">
                                        <table class="table table-filter">
                                            <tbody>
                                            @foreach($articles as $article)
{{--                                                @if($user->id == $article->user_id)--}}
                                                    <tr data-status="pagado">
                                                        <td>
                                                            <div class="media">
                                                                <a href="/articles/{{ $article->id }}" class="pull-left">
                                                                    <img src="/images/articles/{{ $article->user_id }}/thumb_{{ $article->thumbnail }}" class="media-photo">
                                                                </a>
                                                                <div class="media-body">
                                                                    {{--<span class="media-meta pull-right">Febrero 13, 2016</span>--}}
                                                                    <span class="media-meta pull-right">{{ $article->created_at->format('d M Y') }}</span>

                                                                    <h4 class="title">
                                                                        <a href="/articles/{{ $article->id }}"> {{ $article->title }}</a>
                                                                        @if(!Auth::guest())
                                                                            @if(Auth::user()->id == $article->user_id)
                                                                                <a href="/articles/{{ $article->id }}/edit?red=profile" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>
                                                                                {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id], 'class' => 'form-delete-userpage']) !!}
                                                                                <button type="submit" class="btn btn-danger btn-xs"><em class="fa fa-trash"></em></button>
                                                                                {!! Form::close() !!}
                                                                            @endif
                                                                        @endif
                                                                        <span class="media-meta pull-right">{{ $article->category }}</span>
                                                                    </h4>
                                                                    <?php
                                                                        // remove text formatting tags
                                                                        $article_text =  strip_tags($article->text);
                                                                    ?>
                                                                    <p class="summary">{{ str_limit($article_text, $limit = 300, '...') }} <a href="/articles/{{ $article->id }}">read more</a></p>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <p>No Article Found</p>
                @endif

                    <div class="row">
                        <div class="col-md-12">
                            {!! $articles->render() !!}
                        </div>
                    </div>
            </div>
        </div>
        @endif
    @stop
@endif