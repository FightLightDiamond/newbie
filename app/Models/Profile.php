<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profiles';

    public $fillable = ['user_id', 'height', 'weight', 'round_one', 'round_two', 'round_three',
        'image_one', 'image_two', 'image_three', 'website', 'hobby', 'slogan'];

    public function scopeFilter($query, $input)
    {
        foreach ($this->fillable as $value) {
            if (isset($input[$value])) {
                $query->where($value, $input[$value]);
            }
        }
        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
