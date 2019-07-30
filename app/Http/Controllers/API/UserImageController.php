<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserImageController extends Controller
{
	protected $model;

	public function likeOrDislike($imageId, $isLike)
    {
    	if(!auth()->check()) {
    		auth()->loginUsingId(rand(1, 5));
	    }

    	$user = auth()->user();
    	$result = $user->likeImage($imageId, $isLike);

    	return response()->json($result);
    }
}
