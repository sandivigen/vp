@extends('layout.main')

@section('title', $heading)

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
                                <div>
                                    <h3>
                                        Комментарии пользователя {{ $user->name }} ({{ $comments_count }})
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