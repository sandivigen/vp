<?php

namespace App\Commands;

use App\Commands\Command;
use App\ArticlesComments;

class DestroyArticleCommentCommand extends Command {

    public $id;

    public function __construct($id ){
        $this->id = $id;
    }
    public function handle() {
        return ArticlesComments::where('id', $this->id)->delete();
    }
}
