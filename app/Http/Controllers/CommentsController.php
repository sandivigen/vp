<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Commands\StoreCommentCommand;
use App\Commands\UpdateCommentCommand;
use App\Commands\DestroyCommentCommand;

use App\Comments;

use Auth;

class CommentsController extends Controller
{
    /**
     * Страница для администратора со списком всех комментариев
     */
    public function index()
    {
        $comments = Comments::where('user_id', '>', -1)->orderBy('id', 'desc')->paginate(10);
        $comments_count = Comments::all()->count();
        $amount_pages = ceil($comments_count / 10);
        $heading = 'Все комментарии';

        return view('admin_table_comments', array(
            'heading' => $heading,
            'comments' => $comments,
            'amount_pages' => $amount_pages,
        ));
    }


    /**
     * Тестовый инструмент для быстрого добавления комментария для администратора
     */
    public function create()
    {
        $heading = 'Добавить комментарий';
        return view('create_comment', array('heading' => $heading));
    }


    /**
     * Добавление комментария
     */
    public function store(Request $request)
    {
        // Получаем данные из формы
        $comment_text = $request->input('comment_text');
        $type_category = $request->input('type_category');
        $category_item_id = $request->input('category_item_id');
        
        if(Auth::guest()){
            $user_id = 0;
            $guest_name = $request->input('guest_name');
            if (!$guest_name)
                $guest_name = 'Guest';
        } else {
            $user_id = Auth::user()->id;
            $guest_name = '';
        }

        // Create Command
        $command = new StoreCommentCommand($comment_text, $user_id, $guest_name, $type_category, $category_item_id);

        // Run Command
        $this->dispatch($command);

//        $redirect_url = $type_category.'s/'.$category_item_id;
//        return redirect($redirect_url)
//            ->with('message', $guest_name.' Ваше сообщение успешно добавленно');

        return back()->with('message', 'Ваше сообщение успешно добавленно');
    }

    /**
     * Просмотр конкретного комментария
     */
    public function show($id)
    {
        abort(404, '404');
    }

    /**
     * Тестовый инструмент для быстрого редактирования любого комментария для администратора
     */
    public function edit($id) {
        $comment = Comments::find($id);
        $heading = 'Редактировать комментарий';
        return view('edit_comment', compact('comment', 'heading'));
    }

    /**
     * Обработка формы редактирования комментария
     */
    public function update(Request $request, $id) {
        // Get Input
        $comment_text = $request->input('comment_text');
        $user_id = $request->input('user_id');
        $guest_name = $request->input('guest_name');
        $type_category = $request->input('type_category');
        $category_item_id = $request->input('category_item_id');
        $publish = $request->input('publish');
        $like = $request->input('like');

        // Create Command
        $command = new UpdateCommentCommand($id, $comment_text, $user_id, $guest_name, $type_category, $category_item_id, $publish, $like);
        // Run Command
        $this->dispatch($command);

        return \Redirect::route('admin_table_comments.index')
            ->with('message', 'Комментарий обновлен');
    }


    /**
     * Удаление комментария из базы данных
     */
    public function destroy($id)
    {
        $command = new DestroyCommentCommand($id);

        // Admin check
        $auth_user_role = Auth::user()->role;
        if ($auth_user_role == 1) {
            $this->dispatch($command);
            return back()->with('message', 'Комментарий удален из базы данных(с правами администратора)');
        } else {
            // Записываю в лог попытку хака
            DB::table('hacking_attempt')->insert([
//                'place' => 'удаление комментария из бд '.$uri,
                'object' => 'комментарий номер: '.$id,
                'who' => 'попытался пользователь: '.$auth_user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            return back()->with('message', 'Вы не можите удалить комментарий, у вас нет прав');
        }
    }


    /**
     * Сделать комментарий неопубликованным
     */
    public function delete(Request $request, $id)
    {
        $comment = Comments::find($id);
        $comment->publish = 0;

        // Проверка является ли сообщение того пользователя, который пытается его удалить
        $user_id = $comment->user_id;
        $auth_user_id = Auth::user()->id;
        $uri = $request->path();

        // Если залогениный пользователь является автором комментария
        if ($user_id == $auth_user_id) {
            $comment->save();
            return back()->with('message', 'Комментарий удален');
        } else {
            // Админу можно
            if ($auth_user_id == 1) {
                $comment->save();
                return back()->with('message', 'Вы убрали комментарий из публикации с правами администратора');
            } else {
                // Записываю в лог попытку хака
                DB::table('hacking_attempt')->insert([
                    'place' => 'удаление комментария '.$uri,
                    'object' => 'комментарий номер: '.$id,
                    'who' => 'попытался пользователь: '.$auth_user_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
                return back()->with('message', 'У вас нет прав для удаления этого комментария');
            }
        }
    }


    /**
     * Сделать комментарий опубликованным
     */
    public function unDelete(Request $request, $id)
    {
        $comment = Comments::find($id);
        $comment->publish = 1;

        // Проверка является ли сообщение того пользователя, который пытается его удалить
        $user_id = $comment->user_id;
        $auth_user_id = Auth::user()->id;
        $uri = $request->path();

        // Если залогениный пользователь является автором комментария
        if ($user_id == $auth_user_id) {
            $comment->save();
            return back()->with('message', 'Изменено состояние комментария: опубликован ');
        } else {
            // Админу можно
            if ($auth_user_id == 1) {
                $comment->save();
                return back()->with('message', 'Вы опубликовали комментарий с правами администратора');
            } else {
                // Записываю в лог попытку хака
                DB::table('hacking_attempt')->insert([
                    'place' => 'сделать коммент вновь видимым '.$uri,
                    'object' => 'комментарий номер: '.$id,
                    'who' => 'попытался пользователь: '.$auth_user_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
                return back()->with('message', 'У вас нет прав для публикации этого комментария');
            }
        }
    }


    /**
     * Редактирование коммента в профиле пользователя, через модальное окно
     */
    public function updatePopup(Request $request, $id)
    {
        // Get Input
        $comment_text = $request->input('comment_text');

        // Get val in base
        $comment = Comments::find($id);
        $user_id = $comment->user_id;
        $guest_name = $comment->guest_name;
        $type_category = $comment->type_category;
        $category_item_id = $comment->category_item_id;
        $publish = $comment->publish;
        $like = $comment->like;

        // Проверка является ли сообщение того пользователя, который пытается его редактировать
        $auth_user_id = Auth::user()->id;
        $uri = $request->path();

        if ($user_id == $auth_user_id) {

            // Create Command
            $command = new UpdateCommentCommand($id, $comment_text, $user_id, $guest_name, $type_category, $category_item_id, $publish, $like);

            // Run Command
            $this->dispatch($command);

            return back()->with('message', 'Комментарий отредактирован');

        } else {

            // Записываю в лог попытку хака
            DB::table('hacking_attempt')->insert([
                'place' => 'редактирование комментария '.$uri,
                'object' => 'комментарий номер: '.$id,
                'who' => 'попытался пользователь: '.$auth_user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            return back()->with('message', 'У вас нет прав для редактирования этого комментария');
        }
    }
}
