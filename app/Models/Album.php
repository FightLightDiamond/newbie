<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public $table = 'albums';
    public $fillable = ['title', 'user_id', 'description', 'views', 'like'];

    public function scopeFilter($query, $input)
    {
        foreach ($this->fillable as $value) {
            if (isset($input[$value])) {
                $query->where($value, $input[$value]);
            }
        }
        return $query;
    }

    public function images() {
        return $this->hasMany(Image::class, 'album_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
