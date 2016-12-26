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

//    Debugbar::info($user);
//    Debugbar::info($user_t);
    ?>


    @section('content')
        @if(Auth::guest())
            <p>Только зарегистрированные пользователи могут просматривать эту страницу. Зарегестрируйтесь или войдите в свою учетную запись.</p>
        @else
            <div class="row">

                @if($comments)
                    <section class="content">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <?php
                                        // amount of comments
                                        $count_comment = 0;
                                        foreach($comments as $comment) {
                                            if($user->id == $comment->user_id)
                                                $count_comment += 1;
                                        }
                                    ?>
                                    <div>
                                        <h3>
                                            @if(Auth::user()->id == $user->id)
                                                Мои комментарии ({{ $count_comment }})
                                            @else
                                                Комментарии пользователя {{ $user->name }} ({{ $count_comment }})
                                            @endif
                                        </h3>
                                    </div>
                                    <div class="table-container">
                                        <table class="table table-filter">
                                            <tbody>
                                                @foreach($comments as $comment)
                                                    {{--{{ Debugbar::info($comment) }}--}}
{{--                                                    @if($user->id == $comment->user_id)--}}
                                                        <tr data-status="pagado">
                                                            <td>
                                                                <div class="media">
                                                                    <a href="#" class="pull-left">
                                                                        {{--<img src="/images/{{ $article->thumbnail }}" class="media-photo">--}}
                                                                    </a>
                                                                    <div class="media-body">
                                                                        <span class="media-meta pull-right">{{ $comment->created_at->format('d M Y') }}</span>
                                                                        <h4 class="title">
                                                                            <a href="/articles/{{ $comment->category_item_id }}"> {{ $article_list[$comment->category_item_id] }}</a>
                                                                            {{--<span class="pull-right pagado">Like (0)</span>--}}
                                                                        </h4>
                                                                        <p class="summary">{{ $comment->comment_text }}</p>
                                                                    </div>
                                                                </div>
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

                    <div class="row">
                        <div class="col-md-12">
                            {!! $comments->render() !!}
                        </div>
                    </div>
                @else
                    <p>Комментариев не найдено</p>
                @endif

            </div>
        </div>
        @endif
    @stop
@endif