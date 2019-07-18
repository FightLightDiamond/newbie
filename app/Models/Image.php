<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $table = 'images';
    public $fillable = ['user_id', 'title', 'description', 'image', 'album_id', 'like', 'views'];

    public function scopeFilter($query, $input)
    {
        foreach ($this->fillable as $value) {
            if (isset($input[$value])) {
                $query->where($value, $input[$value]);
            }
        }

        return $query;
    }

    public function album()
    {
        return $this->belongsTo(Album::class, 'album_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
