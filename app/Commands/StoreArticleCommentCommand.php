<?php

namespace App\Commands;

use App\Commands\Command;
use App\ArticlesComments;

class StoreArticleCommentCommand extends Command {
    
    public $comment_text;
    public $user_id;
    public $article_id;

    public function __construct($comment_text, $user_id, $article_id){
        $this->comment_text = $comment_text;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }
    public function handle() {
        return ArticlesComments::create([
            'comment_text' => $this->comment_text,
            'user_id' => $this->user_id,
            'article_id' => $this->article_id,
        ]);
    }
}
