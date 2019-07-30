<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUserLike extends Model
{
    protected $table = 'image_user_likes';

    protected $fillable = ['user_id', 'image_id', 'is_like'];
}
