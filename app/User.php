<?php

namespace App;

use App\Models\Album;
use App\Models\Image;
use App\Models\ImageUserLike;
use App\Models\Profile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function scopeFilter($query, $input)
	{
		foreach ($this->fillable as $value) {
			if (isset($input[$value])) {
				$query->where($value, $input[$value]);
			}
		}

		return $query;
	}

    public function images()
    {
        return $this->hasMany(Image::class, 'user_id');
    }

    public function albums()
    {
        return $this->hasMany(Album::class, 'user_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

	public function likeImages()
	{
		return $this->belongsToMany(Image::class, 'image_user_likes',
			'user_id', 'image_id')->withTimestamps();
	}

	public function likeImage($imageId, $isLike = false)
	{
		return $this->likeImages()->attach($imageId, ['is_like' => $isLike]);
	}

	public function likeOrDislikeImage($imageId, $isLike = false)
	{
		$updated = $this->imageUserLikes()->where('image_id', $imageId)->update(['is_like' => $isLike]);

		if($updated === 0) {
			return $this->likeImage($imageId, $isLike);
		}

		return $updated;
	}

	public function scopeMy($query)
	{
		return $query->where('id', auth()->id());
	}

	public function imageUserLikes()
	{
		return $this->hasMany(ImageUserLike::class, 'user_id');
	}
}
