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
            <div class="row">

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
                            <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>



                            {{--<div class="panel-controls-article">--}}

                                @if(!Auth::guest())
                                    @if(Auth::user()->id == $comment->user_id)
                                        {{--<div class="comment-controls">--}}
                                            {!! Form::open(array('action' => ['CommentsController@nopublish', $comment->id], 'enctype' => 'multipart/form-data')) !!}
                                            {!! Form::button('<i class="icon-trash"></i>', ['class' => 'btn', 'role' => 'button', 'type' => 'submit']) !!}
                                            {!! Form::close() !!}
                                        {{--</div>--}}
                                    @endif
                                @endif
                            {{--</div>--}}
                        </div>




                        <div class="panel-body">
                            {{ $comment->comment_text }}
                            {{--<hr>--}}
                            <ul class="list-unstyled list-inline">

                                {{--<li>--}}
                                    {{--<button class="btn btn-xs btn-info" type="button" data-toggle="collapse" data-target="#view-comments-{{$article->id}}" aria-expanded="false" aria-controls="view-comments-{{$article->id}}">--}}
                                        {{--<i class="fa fa-comments-o"></i>--}}
                                        {{--Коментарии--}}
                                    {{--</button>--}}
                                {{--</li>--}}

                                {{--<li>--}}
                                    {{--{!! Form::open() !!}--}}
                                    {{--{!! Form::hidden('like_status', $article->id) !!}--}}
                                    {{--<button type="submit" class="btn btn-info btn-xs">--}}
                                        {{--<i class="fa fa-thumbs-up"></i>--}}
                                        {{--Нравится--}}
                                        {{--<span class="lake-count">3</span>--}}
                                    {{--</button>--}}
                                    {{--{!! Form::close() !!}--}}
                                {{--</li>--}}


                            </ul>
                        </div>

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

