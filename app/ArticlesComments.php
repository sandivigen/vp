<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlesComments extends Model
{
    // Model Table
    protected $table = 'articles_comments';

    // Mass Assignable
    protected  $fillable = ['comment_text', 'user_id', 'article_id'];

    // Excluded Atrributes
    protected $hidden = [];
}
