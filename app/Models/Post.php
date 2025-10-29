<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // allow mass assignmenttinker usign the php  
    protected $fillable=['title','body'];
}
