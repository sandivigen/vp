<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
    // Model Table
    protected $table = 'accessories';

    // Mass Assignable
    protected  $fillable = ['name'];

    // Excluded Atrributes
    protected $hidden = [];
}
