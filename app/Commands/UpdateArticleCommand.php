<?php

namespace App\Commands;

use App\Commands\Command;
use App\Articles;

class UpdateArticleCommand extends Command {

    public $id;
    public $title;
    public $category;
//    public $user_id;
    public $thumbnail;
    public $text;
    public $video_id;
    public $start_video;
    public $tags;


    public function __construct($id, $title, $category, $thumbnail, $text, $video_id, $start_video, $tags ){
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
//        $this->user_id = $user_id;
        $this->thumbnail = $thumbnail;
        $this->text = $text;
        $this->video_id = $video_id;
        $this->start_video = $start_video;
        $this->tags = $tags;
    }

    public function handle()
    {
        return Articles::where('id', $this->id)->update(array(
            'title' => $this->title,
            'category' => $this->category,
//            'user_id' => $this->user_id,
            'thumbnail' => $this->thumbnail,
            'text' => $this->text,
            'video_id' => $this->video_id,
            'start_video' => $this->start_video,
            'tags' => $this->tags,
        ));
    }
}
