<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Articles;
use App\User;
use App\Comments;

use File;

use Auth;
use Image;


class UserController extends Controller
{
    public function profile() {
        $heading = 'Мой профиль 1';
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }
    public function update_avatar(Request $request) {
        // Handle the user upload of avatar
        $heading = 'Мой профиль';
        $avatar = $request->file('avatar');

        // если миниатюра существует, а она всегда существует, проверку можно удалить
        if ($avatar) {

            $user_id = Auth::user()->id;                                            // получаем id залогиненого пользователя
            $avatar_filename = $avatar->getClientOriginalName();                    // Получим имя картинки из объекта

            $symbols_alignment = 0;                                                 // Делаем дополнительные символы, для корректного отображения порядкового счета аватарок ava_00001.jpg
            if ($user_id < 9)        { $symbols_alignment = "00000"; }
            elseif ($user_id < 99)   { $symbols_alignment = "0000"; }
            elseif ($user_id < 999)  { $symbols_alignment = "000"; }
            elseif ($user_id < 9999) { $symbols_alignment = "00"; }

            $ext_info = pathinfo($avatar_filename);                                 // получаем элементы файла(имя, разшерение..)
            $file_extension = ".".$ext_info['extension'];                           // получаем расшерение файла

            $avatar_filename = 'ava_'.$symbols_alignment.$user_id.$file_extension;  // создаем уникальное имя файла
            $path_avatar = 'uploads/avatars/';                                      // создаем путь к папке, где хранятся аватарки
            $path_avatar_file = $path_avatar . '/' . $avatar_filename;              // Создаем путь для оптимизированного файла
            $avatar->move(public_path($path_avatar), $avatar_filename);             // создает копию оригинала на сервере, для последующей обработки
            $img = Image::make($path_avatar_file);                                  // Добавляет объект оригинальной фотографии, для обработки

            // Обрезаем по меньшей стороне
            $width = 200;
            $height = 200;
            $img->width() > $img->height() ? $width=null : $height=null;            // Большая сторона будет обрезатся
            $img->resize($width, $height, function ($constraint) {                  // Обрезаем более широкую или узкую сторону
                $constraint->aspectRatio();                                         // образаем пропорционально от центра
            });
            $img->fit(200);                                                         // Обрезаем по меньшей стороне
            $img->save($path_avatar_file);                                          // сохраняем оптимизированную картинку, ПЕРЕЗАПИСЫВАЯ оригинальную картинку

            $user = Auth::user();                                                   // Получаем массив пользователя

            $old_avatar_filename = $user->avatar;                                   // Название предыдущего файла картинки
            if ($old_avatar_filename != 'no_avatar.jpg') {                          // Если название не менялось, стоит картинка по умолчанию, то ее трогать не будем
                $old_path_avatar_file = $path_avatar . '/' . $old_avatar_filename;  // путь к старому файлу
                File::delete($old_path_avatar_file);                                // удаляем старый файл
            }

            $user->avatar = $avatar_filename;                                       // Вносим новое имя файла картинки в объект юзера
            $user->save();                                                          // скохраняем новое имя файла в базе данных
        }
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }

    // Страница содержащая список статей данного пользователя
    public function profilePageArticles($user_name) {

        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

//        print_r($articles);

        $articles = Articles::where('user_id', '=', $user_id)->paginate(3);

        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;


            return view('profile_page_articles', array(
                'heading' => $heading,
                'articles' => $articles,
                'user_exists' => 1,
                'user' => $user,
            ));
        } else {

            return view('profile_page_articles', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }
    public function profilePageComments($user_name) {

        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

//        $articles = Articles::where('user_id', '=', $user_id)->paginate(3);

//        $comments = Comments::all()->sortByDesc('id');
        $comments = Comments::where('user_id', '=', $user_id)->paginate(3);
        $articles = Articles::all();
        $users = User::all();

        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page_comments', array(
                'heading' => $heading,
                'articles' => $articles,
                'comments' => $comments,
                'user_exists' => 1,
                'user' => $user,
            ));
        } else {

            return view('profile_page_comments', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }

    public function profilePage($user_name) {

        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

        $comments = Comments::where('user_id', '=', $user_id)->paginate(3);
        $articles = Articles::all();

//        print_r($users['id']);
        
        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page', array(
                'heading' => $heading,
                'articles' => $articles,
                'comments' => $comments,
                'user_exists' => 1,
                'user' => $user,
                'user_name' => $user_name,
                'user_id' => $user_id,
            ));
        } else {

            return view('profile_page', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }

}
