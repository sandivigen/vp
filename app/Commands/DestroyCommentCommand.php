<?php

namespace App\Commands;

use App\Commands\Command;
use App\Comments;

class DestroyCommentCommand extends Command {

    public $id;

    public function __construct($id ){
        $this->id = $id;
    }
    public function handle() {
        return Comments::where('id', $this->id)->delete();
    }
}
