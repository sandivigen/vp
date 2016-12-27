<h3>Оставить комментарий</h3>
<div class="container_">
    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(array('action' => 'CommentsController@store', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal')) !!}

            @if(Auth::guest())
                <div class="form-group">
                    <label class="control-label col-xs-1">Name</label>
                    <div class="col-xs-11">
                        {!! Form::text('guest_name', $value='', $attributes = ['class' => 'form-control', 'name' => 'guest_name', 'placeholder' => 'Guest']) !!}
                    </div>
                </div>
            @else
                {!! Form::hidden('guest_name', 'guest') !!}
            @endif

            <div class="form-group">
                @if(Auth::guest())
                    <label class="control-label col-xs-1">Text</label>
                @else
                    <img class="control-label col-xs-1" src="/uploads/avatars/{{ $user[1]['avatar'] }}" >
                @endif
                <div class="col-xs-11">
                    {!! Form::textarea('comment_text', $value='', $attributes = ['class' => 'form-control', 'name' => 'comment_text', 'rows'=> 3, 'placeholder' => 'Текст вашего комментария']) !!}
                </div>
            </div>

            {!! Form::hidden('type_category', 'article') !!}
            {!! Form::hidden('category_item_id', $article->id) !!}

            <div class="form-group">
                <div class="col-xs-offset-1 col-xs-8">
                    {!! Form::submit('Отправить', $attributes = ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
