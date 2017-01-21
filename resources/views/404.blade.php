@extends('layout.main')

@section('title', $heading)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Ошибка 404</div>

                    <div class="panel-body">
                        <p>{{ $message }}</p>
                        @if($recommended == 'show article')
                            <p>Предлагаем вам посмотреть популярные статьи</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

