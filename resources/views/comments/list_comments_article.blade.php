{{--Блок комментариев--}}
<div class="" id="article-comment-block">
    <div class="row">
        <div class="col-sm-12">

            <?php
                $comment_count = 0;
                foreach ($article_comment as $comment) {
                    if($comment->type_category == 'article' && $comment->category_item_id == $article->id && $comment->publish)
                        $comment_count += 1;
                }

            ?>
            <h3>Комментарии ({{ $comment_count }})</h3>
        </div>
    </div>

    @foreach($article_comment as $comment)

        @if($comment->type_category == 'article' && $comment->category_item_id == $article->id && $comment->publish)
            <div class="row" id="comment-id-{{$comment->id}}">

                <div class="col-sm-1 ">
                    <div class="thumbnail">
                        {{--If an unauthorized user--}}
                        @if($comment['user_id'] == 0)
                                <img class="img-responsive user-photo" src="/uploads/avatars/{{ $user[$comment->user_id]['avatar'] }}" >
                        @else
                            <a href="/user/{{ $user[$comment->user_id]['name'] }}">
                                <img class="img-responsive user-photo" src="/uploads/avatars/{{ $user[$comment->user_id]['avatar'] }}" >
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-sm-11">

                    <div class="panel panel-default comment-icon-right ">
                        <div class="panel-heading">

                            {{--If an unauthorized user--}}
                            @if($comment['user_id'] == 0)
                                <strong><span>{{ $comment['guest_name'] }}</span></strong>
                            @else
                                <strong><a href="/user/{{ $user[$comment->user_id]['name'] }}">{{ $user[$comment->user_id]['name'] }}</a></strong>
                            @endif

                            @if($comment->created_at != $comment->updated_at)
                                <span class="text-muted"><small>{{ $comment->updated_at->diffForHumans() }} (изменено)</small></span>
                            @else
                                <span class="text-muted"><small>{{ $comment->created_at->diffForHumans() }}</small></span>
                            @endif


                            @if(!Auth::guest())
                                @if(Auth::user()->id == $comment->user_id)

                                    {!! Form::open(array('action' => ['CommentsController@updatePopup', $comment->id], 'enctype' => 'multipart/form-data', 'class' => 'form-delete-userpage', 'id' => 'form-update-popup')) !!}
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#updateComment-{{ $comment->id }}"><em class="fa fa-pencil"></em></button>
                                        <textarea id="comment_text" name="comment_text"></textarea>
                                        <button type="submit" id="comment_update_submit"></button>

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
                        </div>

                        <div class="panel-body">
                            {{ $comment->comment_text }}
                        </div>
                        <div id="updateComment-{{ $comment->id }}" class="collapse panel-footer">
                            <textarea name="comment_text" class="form-control" id="comment_input_text" cols="30" rows="4" >{{ $comment->comment_text }}</textarea>
                            <button type="button" class="btn btn-primary" id="comment_input_submit" onclick="inputCommentText()">Сохранить</button>
                        </div>
                        <script>
                            function inputCommentText() {
                                var textComment = $('#comment_input_text').val();
                                $('#comment_text').val(textComment);
                                document.getElementById('comment_update_submit').click();
                            }
                        </script>

                        {{--Блок комментариев: ответы на коменты--}}
                        {{--<div class="panel-footer clearfix">--}}
                            {{--<div class="collapse" id="view-comments-{{$article->id}}">--}}
                                {{--<div class="row">--}}
                                    {{--<div class="col-sm-12">--}}
                                        {{--<div class="panel panel-default">--}}
                                            {{--<div class="panel-heading">--}}
                                                {{--<a href="/user/{{ $user[1]['name'] }}"><img style="height: 25px;" class="_img-responsive _user-photo" src="/uploads/avatars/{{ $user[1]['avatar'] }}" ></a>--}}
                                                {{--<strong><a href="/user/{{ $user[1]['name'] }}">{{ $user[1]['name'] }}</a></strong>--}}
                                                {{--<span class="text-muted">--}}
                                                    {{--commented 5 days ago--}}
                                                    {{--{{ $comment->created_at->diffForHumans() }}--}}
                                                {{--</span>--}}
                                            {{--</div>--}}
                                            {{--<div class="panel-body">--}}
                                                {{--Published text message.--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-lg-12">--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" class="form-control" placeholder="Text message...">--}}
                                      {{--<span class="input-group-btn">--}}
                                        {{--<button class="btn btn-default" type="button">Send</button>--}}
                                      {{--</span>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                    </div>
                </div>
            </div>

        @endif
    @endforeach
</div>

