<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




//Route::get('/accessories', function () {
//    return view('accessories');
//});

//Route::resource('accessories', 'AccessoriesController');

Route::resource('articles', 'ArticlesController');
Route::resource('my_articles', 'ArticlesController@showMyArticles');
Route::get('articles/category/{category_name}', 'ArticlesController@showCategory');


Route::resource('comments', 'CommentsController');
Route::post('delete_comment/{id}', 'CommentsController@delete');
Route::post('update_comment/{id}', 'CommentsController@updatePopup');


Route::get('profile', 'UserController@profile');
Route::post('profile', 'UserController@update_avatar');
Route::get('user/{user_name}/comments', 'UserController@profilePageComments');
Route::get('user/{user_name}/articles', 'UserController@profilePageArticles');
Route::get('user/{user_name}', 'UserController@profilePage');


//Route::get('/contact', function () {
//    return view('contact');
//});

Route::auth();

Route::get('/', 'HomeController@index');
//Route::get('/', function () {
//    return view('welcome');
//});




// Так можно кастомный контроллер подключить, delete не имеет значение, нужено только указать параметр {id}
//Route::post('delete/{id}', 'CommentsController@destroy');
// Вот форма
//{!! Form::open(array('action' => ['CommentsController@destroyin', $comment->id], 'enctype' => 'multipart/form-data')) !!}
//{!! Form::submit('Delete', $attributes = ['class' => 'btn btn-danger btn-xs']) !!}
//{!! Form::close() !!}