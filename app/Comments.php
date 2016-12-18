<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    // Model Table
    protected $table = 'comments';

    // Mass Assignable
    protected  $fillable = [
        'comment_text',
        'user_id',
        'guest_name',
        'type_category',
        'category_item_id',
        'publish',
        'like',
    ];

    // Excluded Attributes
    protected $hidden = [];
}