<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserImageController extends Controller
{

	public function likeOrDislike($imageId, $isLike)
    {
	    $user = auth()->loginUsingId(1);

    	$result = $user->likeOrDislikeImage($imageId, $isLike);

    	return response()->json($result);
    }

    public function countImages(Request $request)
    {
    	$input = $request->all();

    	$user = auth()->loginUsingId(1);

	    $result = $user->likeImages()->filter($input)->count();

	    return response()->json($result);
    }

    public function getImages(Request $request)
    {
	    $input = $request->all();
	    $input['user_id'] = 1;

	    $input = $request->all();

	    $user = auth()->loginUsingId(1);

	    $result = $user->likeImages()->filter($input)->simplePaginate();

	    return response()->json($result);
    }
}
