<?php

namespace App\Commands;

use App\Commands\Command;
use App\Articles;

class DestroyArticleCommand extends Command {

    public $id;

    public function __construct($id ){
        $this->id = $id;
    }
    public function handle() {
        return Articles::where('id', $this->id)->delete();
    }
}
