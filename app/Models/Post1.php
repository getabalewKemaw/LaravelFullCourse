<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post1 extends Model
{
    //make the titile and the content fillable to mass assignmnet

    protected $fillable = ['title', 'content'];
}
