<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    // Model Table
    protected $table = 'articles';

    // Mass Assignable
    protected  $fillable = ['category', 'title', 'user_id', 'thumbnail', 'text', 'video_id', 'start_video', 'tags' ];

    // Excluded Atrributes
    protected $hidden = [];

}
