@extends('layout.main')

@section('title', $heading)

@section('content')

                <div class="row">
                    <div class="col-md-12">
                        <img src="uploads/avatars/{{ $user->avatar }}" style="width:150px;border-radius: 50%;margin-right: 25px;">
                        <h2>{{ $user->name }}'s profile</h2>
                        <form enctype="multipart/form-data" action="/profile" method="POST">
                            <lable>Update Profile Image</lable>
                            <input type="file" name="avatar">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="pull-right btn btn-sm btn-primary">
                        </form>
                    </div>
                </div>

@stop
