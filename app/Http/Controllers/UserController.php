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
     * Стараница с редактирование личных данных
     */
    public function profile()
    {
        $heading = 'Редактировать профиль';
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }

    /**
     * Изменения в профиле личных данных
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
     * страница для просмотра разными пользователями c данными, комментами и статьями
     */
    public function profilePage($user_name)
    {
        $user = User::where('name', '=', $user_name)->first(); // получаем объект пользователя

        if (isset($user)) {

            $user_comments = Comments::where('user_id', '=', $user->id)->where('publish', '=', 1)->get()->sortByDesc('id')->take(10);
            $user_articles = Articles::where('user_id', '=', $user->id)->where('publish', '=', 1)->get()->sortByDesc('id')->take(3);
            $articles = Articles::all(); // выбмраем все статьи для определения заголовка к какой статье пренадлежит комментарий
            $articles_count = Articles::where('user_id', '=', $user->id)->where('publish', '=', 1)->count(); // получаем сумму всех статей пользователя
            $comments_count = Comments::where('user_id', '=', $user->id)->where('publish', '=', 1)->count(); // получаем сумму всех сообщений пользователя, из них выбираем опубликванные

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page', array(
                'heading' => $heading,
                'user_articles' => $user_articles,
                'user_comments' => $user_comments,
                'articles_count' => $articles_count,
                'comments_count' => $comments_count,
                'articles' => $articles,
                'user' => $user
            ));
        }
        abort(404, 'show user profile');
    }


    /**
     * Страница содержащая список всех статей данного пользователя
     */
    public function profilePageArticles($user_name)
    {
        $user = User::where('name', '=', $user_name)->first(); // получаем объект пользователя

        if (isset($user)) {

            $articles = Articles::where('user_id', '=', $user->id)->where('publish', '=', 1)->orderBy('id', 'desc')->paginate(2);
            $articles_count = Articles::where('user_id', '=', $user->id)->where('publish', '=', 1)->count(); // счетчик для пагинации
            $amount_pages = ceil($articles_count / 2); // округения для суммы страниц пагинации
            $heading = 'Все статьи пользователя: ' . $user_name;

            return view('profile_page_articles', array(
                'heading' => $heading,
                'articles' => $articles,
                'user' => $user,
                'amount_pages' => $amount_pages,
                'articles_count' => $articles_count,
            ));
        }
        abort(404, 'show user profile');
    }


    /**
     * Страница содержащая список всех комментов данного пользователя
     */
    public function profilePageComments($user_name)
    {
        $user = User::where('name', '=', $user_name)->first(); // получаем объект пользователя

        if (isset($user)) {

            $heading = 'Комментарии пользователя: ' . $user_name;
            $articles = Articles::all(); // для показа к какой статье принадлежит комментарий
            $comments = Comments::where('user_id', '=', $user->id)->where('publish', '=', 1)->paginate(3);
            $comments_count = Comments::where('user_id', '=', $user->id)->where('publish', '=', 1)->count();

            return view('profile_page_comments', array(
                'user' => $user,
                'heading' => $heading,
                'articles' => $articles,
                'comments' => $comments,
                'comments_count' => $comments_count,
            ));
        }
        abort(404, 'show user profile');
    }


    /**
     * Администраторская страница с перечнем всех пользователей
     */
    public function adminTableUsers()
    {
        $users = User::all();

        return view('admin_table_users', array(
            'heading' => 'Админ таблица пользователей',
            'users' => $users,
        ));
    }


    /**
     * Администраторская страница с перечнем всех пользователей, защита от обновления статусов
     */
    public function adminTableUsersUpdate(Request $request)
    {
        // Защита если кто-то попробует поставить роль админа
        if ($request->input('role') == 2 or $request->input('role') == 3 or $request->input('role') == 4) {
            $user = User::find($request->input('user_id'));     // выбираем из базы пользователя
            $user->role = $request->input('role');              // меняем ему роль
            $user->save();                                      // сохраняем новую роль
            return back()->with('message', 'Роль пользователя '.$request->input('user_id').' изменена на '. $request->input('role'));
        } else {
            return back()->with('message', 'Вы не можите установить эту роль');
        }
    }
}



