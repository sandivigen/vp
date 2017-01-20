@extends('layout.main')

@section('title', $heading)

@section('content')
    @if(!Auth::guest())
        @if(Auth::user()->role == 1)
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Articles list</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <a class="btn btn-sm btn-primary btn-create" href="/articles/create"><i class="glyphicon glyphicon-plus"></i> Add article</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th><em class="fa fa-cog"></em></th>
                            <th class="hidden-xs">ID</th>
                            <th>Заголовок</th>
                            <th><a href="#" data-toggle="tooltip" title="ID User - кто создал комментарий">ID u</a></th>
                            <th><a href="#" data-toggle="tooltip" title="Public - опубликован или удален">P</a></th>
                            <th>Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td align="center" class="admin-table-btn-block">
                                        <a href="articles/{{ $article->id }}/edit" class="btn btn-default btn-xs"><em class="fa fa-pencil"></em></a>

                                        {!! Form::open(array('action' => ['ArticlesController@delete', $article->id], 'enctype' => 'multipart/form-data')) !!}
                                        <button type="submit" class="btn btn-default btn-xs"><em class="glyphicon glyphicon-eye-close"></em></button>
                                        {!! Form::close() !!}

                                        {!! Form::open(array('action' => ['ArticlesController@unDelete', $article->id], 'enctype' => 'multipart/form-data')) !!}
                                        <button type="submit" class="btn btn-default btn-xs"><em class="glyphicon glyphicon-eye-open"></em></button>
                                        {!! Form::close() !!}

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['articles.destroy', $article->id]]) !!}
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#destroyArticle-{{ $article->id }}"><em class="fa fa-trash"></em></button>
                                        <!-- Modal -->
                                        <div id="destroyArticle-{{ $article->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">Вы точно хотите удалить комментарий?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Следующий комментарий будет удален из базы данных: </p>
                                                        <p>"{{ $article->title }}"</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger" >Да</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Нет</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </td>
                                    <td class="hidden-xs">{{ $article->id }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->user_id }}</td>
                                    <td>{{ $article->publish }}</td>
                                    <td>{{ $article->created_at }}</td>
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
                                {!! $articles->render() !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <p>У вас нет прав для просмотра данной страницы</p>
        @endif
    @else
        <p>У вас нет прав для просмотра данной страницы</p>
    @endif
@stop
