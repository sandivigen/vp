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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $comments = Comments::all()->sortByDesc('id');
        $comments = Comments::where('user_id', '>', -1)->orderBy('id', 'desc')->paginate(10);
        $comments_count = Comments::all()->count();
        $amount_pages = ceil($comments_count / 10);


        $heading = 'Все комментарии';
        return view('comments', array(
//            'articles' => $articles,
            'heading' => $heading,
//            'users' => $users,
            'comments' => $comments,
            'amount_pages' => $amount_pages,
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heading = 'Добавить комментарий';
        return view('create_comment', array('heading' => $heading));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Get Input
        $comment_text = $request->input('comment_text');
        
        if(Auth::guest()){
            $user_id = 0;
            $guest_name = $request->input('guest_name');
            if (!$guest_name)
                $guest_name = 'Guest';
        } else {
            $user_id = Auth::user()->id;
            $guest_name = '';
        }

        $type_category = $request->input('type_category');
        $category_item_id = $request->input('category_item_id');

        // Create Command
        $command = new StoreCommentCommand($comment_text, $user_id, $guest_name, $type_category, $category_item_id);

        // Run Command
        $this->dispatch($command);

        $redirect_url = $type_category.'s/'.$category_item_id;

        return redirect($redirect_url)
            ->with('message', $guest_name.' Ваше сообщение успешно добавленно');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comments::find($id);
        $heading = 'Редактировать комментарий';
        return view('edit_comment', compact('comment', 'heading'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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

        return \Redirect::route('comments.index')
            ->with('message', 'Comment edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $command = new DestroyCommentCommand($id);

//        $redirect_category = Comments::find($id)->type_category;
//        $redirect_id = Comments::find($id)->category_item_id;
//        $redirect_url = $redirect_category.'s/'.$redirect_id;
//        $text_message = 'Comment #'.$id.' Removed';

        $this->dispatch($command);

        return back()->with('message', 'Комментарий удален(совсем)');

//        return \Redirect::route('comments.index')
//            ->with('message', $text_message);
    }
//    public function destroyin($id)
//    {
//        // need comments for this method!!!
//        $command = new DestroyCommentCommand($id);
//        $this->dispatch($command);
//
//        $text_message = 'Comment #'.$id.' Removed';
////        return \Redirect::route('articles.index')
//        return redirect('articles/32')
//            ->with('message', $text_message);
//    }
    public function delete(Request $request, $id)
    {
        $comment = Comments::find($id);

        // Get Input
        $comment_text = $comment->comment_text;
        $user_id = $comment->user_id;
        $guest_name = $comment->guest_name;
        $type_category = $comment->type_category;
        $category_item_id = $comment->category_item_id;
        $publish = 0;
        $like = $comment->like;

        $uri = $request->path();

        // Create Command
        $command = new UpdateCommentCommand($id, $comment_text, $user_id, $guest_name, $type_category, $category_item_id, $publish, $like);

        // Проверка является ли сообщение того пользователя, который пытается его удалить
        $auth_user_id = Auth::user()->id;

        if ($user_id == $auth_user_id) {
            // Run Command
            $this->dispatch($command);
            return back()
                ->with('message', 'Комментарий удален');
        } else {

            DB::table('hacking_attempt')->insert([
                'place' => 'удаление комментария '.$uri,
                'object' => 'комментарий номер: '.$id,
                'who' => 'попытался пользователь: '.$auth_user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

            return back()
                ->with('message', 'У вас нет прав для удаления этого комментария');
        }




//        $redirect_url = $type_category.'s/'.$category_item_id;
//        return redirect($redirect_url)

    }
}
