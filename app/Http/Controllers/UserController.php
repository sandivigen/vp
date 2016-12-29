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
    /**
     * description
     */
    public function profile()
    {
        $heading = 'Мой профиль 1';
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }

    /**
     * description
     */
    public function update_avatar(Request $request)
    {
        // Handle the user upload of avatar
        $heading = 'Мой профиль';
        $avatar = $request->file('avatar');

        // если миниатюра существует, а она всегда существует, проверку можно удалить
        if ($avatar) {

            $user_id = Auth::user()->id;                                            // получаем id залогиненого пользователя
            $user = Auth::user();                                                   // Получаем массив пользователя

            $symbols_alignment = 0;                                                 // Делаем дополнительные символы, для корректного отображения порядкового счета аватарок ava_00001.jpg
            if ($user_id < 9)        { $symbols_alignment = "00000"; }
            elseif ($user_id < 99)   { $symbols_alignment = "0000"; }
            elseif ($user_id < 999)  { $symbols_alignment = "000"; }
            elseif ($user_id < 9999) { $symbols_alignment = "00"; }

            $avatar_original_filename = $avatar->getClientOriginalName();           // Получим имя картинки из объекта загружанного через форму, это нужно было для того чтобы оставить оригинальное название файла
            $ext_info = pathinfo($avatar_original_filename);                        // получаем масив данных файла(имя, разшерение..)
            $file_extension = ".".$ext_info['extension'];                           // получаем расшерение файла

            $avatar_filename = 'ava_'.$symbols_alignment.$user_id.'e'.time().$file_extension;  // создаем уникальное имя файла
            $path_avatar = 'uploads/avatars/';                                      // создаем путь к папке, где хранятся аватарки
            $path_avatar_file = $path_avatar . $avatar_filename;                    // Создаем путь для оптимизированного файла
            $avatar->move(public_path($path_avatar), $avatar_filename);             // берет картинку из формы и делает копию на сервере
            $img = Image::make($path_avatar_file);                                  // Добавляет объект от оригинальной фотографии, для обработки

            // Обрезаем по меньшей стороне
            $width = 200;
            $height = 200;
            $img->width() > $img->height() ? $width=null : $height=null;            // Большая сторона будет обрезатся
            $img->resize($width, $height, function ($constraint) {                  // Обрезаем более широкую или узкую сторону
                $constraint->aspectRatio();                                         // образаем пропорционально от центра
            });
            $img->fit(200);                                                         // Обрезаем по меньшей стороне
            $img->save($path_avatar_file);                                          // сохраняем оптимизированную картинку, ПЕРЕЗАПИСЫВАЯ оригинальную картинку

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

    /**
     * Страница содержащая список всех статей данного пользователя
     */
    public function profilePageArticles($user_name)
    {
        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

        $articles = Articles::where('user_id', '=', $user_id)->where('publish', '=', 1)->orderBy('id', 'desc')->paginate(2);

        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        // счетчик для пагинации
        $articles_count = Articles::where('user_id', '=', $user_id)->where('publish', '=', 1)->count();
        $amount_pages = ceil($articles_count / 2);
            
        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Все статьи пользователя: ' . $user_name;

            return view('profile_page_articles', array(
                'heading' => $heading,
                'articles' => $articles,
                'user_exists' => 1,
                'user' => $user,
                'amount_pages' => $amount_pages,
            ));
        } else {
            return view('profile_page_articles', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }

    /**
     * Страница содержащая список всех комментов данного пользователя
     */
    public function profilePageComments($user_name)
    {
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

    /**
     * страница для просмотра разными пользователями c данными, комментами и статьями
     */
    public function profilePage($user_name)
    {
        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

        $user_comments = Comments::where('user_id', '=', $user_id)->where('publish', '=', 1)->get()->sortByDesc('id')->take(10);
        $user_articles = Articles::where('user_id', '=', $user_id)->get()->sortByDesc('id')->take(3);
        $articles = Articles::all(); // выбмраем все статьи для определения заголовка к какой статье пренадлежит комментарий
        $articles_count = Articles::where('user_id', '=', $user_id)->count(); // получаем сумму всех статей пользователя
        $comments_count = Comments::where('user_id', '=', $user_id)->where('publish', '=', 1)->count(); // получаем сумму всех сообщений пользователя, из них выбираем опубликванные

        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page', array(
                'heading' => $heading,
                'user_articles' => $user_articles,
                'user_comments' => $user_comments,
                'user_exists' => 1,
                'articles_count' => $articles_count,
                'comments_count' => $comments_count,
                'articles' => $articles,
                'user' => $user
            ));
        } else {

            return view('profile_page', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }

}
