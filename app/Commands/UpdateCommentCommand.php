<?php

namespace App\Commands;

use App\Commands\Command;
use App\Comments;

class UpdateCommentCommand extends Command {

    public $id;
    public $comment_text;
    public $user_id;
    public $guest_name;
    public $type_category;
    public $category_item_id;
    public $publish;
    public $like;

    public function __construct($id, $comment_text, $user_id, $guest_name, $type_category, $category_item_id, $publish, $like){
        $this->id = $id;
        $this->comment_text = $comment_text;
        $this->user_id = $user_id;
        $this->guest_name = $guest_name;
        $this->type_category = $type_category;
        $this->category_item_id = $category_item_id;
        $this->publish = $publish;
        $this->like = $like;
    }
    public function handle() {
        return Comments::where('id', $this->id)->update(array(
            'comment_text' => $this->comment_text,
            'user_id' => $this->user_id,
            'guest_name' => $this->guest_name,
            'type_category' => $this->type_category,
            'category_item_id' => $this->category_item_id,
            'publish' => $this->publish,
            'like' => $this->like,
        ));
    }
}
