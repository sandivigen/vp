@extends('layout.main')

@section('title', $heading)

{{-- if user not exists--}}
@if($user_exists == 1)

    @php
        // Get article list
        $article_list = array();
        foreach($articles as $key=>$value){
            $article_list[$value->id] = $value->title;
        }
        // Debugbar::info($articles[0]);
    @endphp

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
                                    <div>
                                        <h3>{{ $heading }} ({{ $articles_count }})</h3>
                                    </div>
                                    <div class="table-container">
                                        <table class="table table-filter">
                                            <tbody>
                                                @foreach($articles as $article)
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
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        @php
                                            $num_page = (!isset($_GET['page']) ? 1 : $_GET['page']); // если есть Гет параметр то его используем, если нет то это первое вхождение  и это 1-я страница
                                        @endphp
                                        <div class="col col-xs-4 pagination-block-left">Страница {{ $num_page }} из {{ $amount_pages }}
                                        </div>
                                        <div class="col col-xs-8 pagination-block-right">
                                            <ul class="pagination hidden-xs pull-right">
                                                {!! $articles->render() !!}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @else
                    <p>Пользователь пока не написал не одной статьи</p>
                @endif
            </div>
        @endif
    @stop
@endif