@extends('layout.main')

@section('title', $heading)

@section('content')

    @if(!Auth::guest())
        @if(Auth::user()->role == 1)
            <div class="panel panel-default panel-table admin-table-user-page">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">Users list</h3>
                        </div>
                        <div class="col col-xs-6 text-right">
                            <a class="btn btn-sm btn-primary btn-create" href="/articles/create"><i class="glyphicon glyphicon-plus"></i> Add new user</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th><em class="fa fa-cog"></em></th>
                            <th class="hidden-xs">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Дата создания</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($users as $user)
                            <tr>
                                <td align="center" class="admin-table-btn-block">
                                    @if($user->role != 1 AND $user->role != 0)
                                        {!! Form::open(array('action' => 'UserController@adminTableUsersUpdate', 'enctype' => 'multipart/form-data')) !!}
                                        {!! Form::hidden('user_id', $user->id) !!}
                                        <input type="number" name="role" min="2" max="4" value="{{$user->role}}" class="form-control">
                                        <button type="submit" class="btn btn-default"><em class="glyphicon glyphicon-ok"></em></button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                                <td class="hidden-xs">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <p>У вас нет прав для просмотра данной страницы</p>
        @endif
    @else
        <p>У вас нет прав для просмотра данной страницы</p>
    @endif
@stop
