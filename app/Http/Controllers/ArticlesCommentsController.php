<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Commands\StoreArticleCommentCommand;
use App\Commands\DestroyArticleCommentCommand;

use App\Http\Requests;

use Auth;
use App\Articles;
use Illuminate\Support\Facades\Input;

class ArticlesCommentsController extends Controller
{
    public function store(Request $request)
    {
        $comment_text = $request->input('comment_text');
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = 0;
        }
        $article_id = $request->input('article_id');

        // Create Command
        $command = new StoreArticleCommentCommand($comment_text, $user_id, $article_id);

        // Run Command
        $this->dispatch($command);

        return \Redirect::route('articles.show', $article_id)
            ->with('message', 'Comment added');
    }
    public function delete($id)
    {
        $command = new DestroyArticleCommentCommand($id);
        $this->dispatch($command);

        return \Redirect::route('articles.show', $id)
            ->with('message', 'Comment Removed');
    }
}
