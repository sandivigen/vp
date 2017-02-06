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




// Времменно закрыл регистрацию, нужны куки
//Route::auth();


Route::get('/', 'HomeController@index');

Route::resource('articles', 'ArticlesController');                                  // Main
Route::resource('admin_table_articles', 'ArticlesController@adminTableArticles');              // for Admin
Route::get('articles/category/{category_name}', 'ArticlesController@showCategory'); // category Page
Route::get('user/{user_name}/articles', 'UserController@profilePageArticles');      // profile Page
Route::post('delete_article/{id}', 'ArticlesController@delete');                    // UnPublish
Route::post('un_delete_article/{id}', 'ArticlesController@unDelete');               // Publish

Route::resource('admin_table_comments', 'CommentsController');
Route::get('user/{user_name}/comments', 'UserController@profilePageComments');
Route::post('delete_comment/{id}', 'CommentsController@delete');
Route::post('un_delete_comment/{id}', 'CommentsController@unDelete');
Route::post('update_comment/{id}', 'CommentsController@updatePopup');

Route::resource('admin_table_users', 'UserController@adminTableUsers');              // Админ таблица с пользователями
Route::post('admin_table_users', 'UserController@adminTableUsersUpdate');              // Изменение роли в админ таблице с пользователями
Route::get('profile', 'UserController@profile');
Route::get('user/{user_name}', 'UserController@profilePage');
Route::post('profile', 'UserController@update_avatar');

Route::post('/edit', [
    'uses' => 'LikesController@ajaxLikes',
    'as' => 'edit'
]);






//Route::get('/contact', function () {
//    return view('contact');
//});


//Route::get('/', function () {
//    return view('welcome');
//});




// Так можно кастомный контроллер подключить, delete не имеет значение, нужено только указать параметр {id}
//Route::post('delete/{id}', 'CommentsController@destroy');
// Вот форма
//{!! Form::open(array('action' => ['CommentsController@destroyin', $comment->id], 'enctype' => 'multipart/form-data')) !!}
//{!! Form::submit('Delete', $attributes = ['class' => 'btn btn-danger btn-xs']) !!}
//{!! Form::close() !!}