<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    // Model Table
    protected $table = 'lakes';

    // Mass Assignable
    protected  $fillable = [
        'user_id',
        'post_id',
        'category_post_id',
        'count',
    ];

    // Excluded Attributes
    protected $hidden = [];
}
