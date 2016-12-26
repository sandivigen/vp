@extends('layout.main')

@section('title', $heading)

@section('content')

    <div class="panel panel-default panel-table">
        <div class="panel-heading">
            <div class="row">
                <div class="col col-xs-6">
                    <h3 class="panel-title">Comments list</h3>
                </div>
                <div class="col col-xs-6 text-right">
                    <a class="btn btn-sm btn-primary btn-create" href="/comments/create"><i class="glyphicon glyphicon-plus"></i> Add comment</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-striped table-bordered table-list">
                <thead>
                <tr>
                    <th><em class="fa fa-cog"></em></th>
                    <th class="hidden-xs">ID</th>
                    <th>Текст комментария</th>
                    <th><a href="#" data-toggle="tooltip" title="ID User - кто создал комментарий">ID u</a></th>
                    <th><a href="#" data-toggle="tooltip" title="Если отправил на авторизированный пользователь"> Guest name</a></th>
                    <th><a href="#" data-toggle="tooltip" title="В кокой категории был создан">C_Category</a></th>
                    <th><a href="#" data-toggle="tooltip" title="ID Item - к какой ид пришадлежит(пр. категория: статьи, ид: 102. Этот комент для 102 статьи">i</a></th>
                    <th><a href="#" data-toggle="tooltip" title="Public - опубликован или удален">P</a></th>
                    <th><a href="#" data-toggle="tooltip" title="Like - счетчик лайков">L</a></th>
                    <th>Дата создания</th>
                </tr>
                </thead>
                <tbody>

                @foreach($comments as $comment)
                    <tr>
                        <td align="center" class="comment-btn-block">
                            <a href="comments/{{ $comment->id }}/edit" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>

                            {!! Form::open(array('action' => ['CommentsController@nopublish', $comment->id], 'enctype' => 'multipart/form-data')) !!}
                            <button type="submit" class="btn btn-default btn-xs"><em class="glyphicon glyphicon-eye-close"></em></button>
                            {!! Form::close() !!}

                            {!! Form::open(['method' => 'DELETE', 'route' => ['comments.destroy', $comment->id]]) !!}
                            <button type="submit" class="btn btn-danger btn-xs"><em class="fa fa-trash"></em></button>
                            {!! Form::close() !!}
                        </td>
                        <td class="hidden-xs">{{ $comment->id }}</td>
                        <td>{{ $comment->comment_text }}</td>
                        <td>{{ $comment->user_id }}</td>
                        <td>{{ $comment->guest_name }}</td>
                        <td>{{ $comment->type_category }}</td>
                        <td>{{ $comment->category_item_id }}</td>
                        <td>{{ $comment->publish }}</td>
                        <td>{{ $comment->like }}</td>
                        <td>{{ $comment->created_at }}</td>
                    </tr>
                @endforeach


                </tbody>
            </table>

        </div>
        <div class="panel-footer">
            <div class="row">
                @php
                    $num_page = (!isset($_GET['page']) ? 1 : $_GET['page']); // если есть Гет параметр то его используем, если нет то это первое вхождение  и это 1-я страница
                @endphp
                <div class="col col-xs-4">Страница {{ $num_page }} из {{ $amount_pages }}
                </div>
                <div class="col col-xs-8">
                    <ul class="pagination hidden-xs pull-right">
                        {!! $comments->render() !!}
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
        </div>
    </div>






@stop
