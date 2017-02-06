<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Likes;

class LikesController extends Controller
{
    /**
     * ajax send data for likes
     */
    public function ajaxLikes(Request $request)
    {

        $user = Auth::user();

        if ($user) {
            $like = Likes::where('user_id', '=', $user->id)
                ->where('post_id', '=', $request['post_id'])
                ->where('category_post_id', '=', $request['category_post_id'])
                ->first();

            if (!$like)
            { // Если пользователь еще не оценивал
                $like = new Likes;
                $like->user_id = $user->id;
                $like->post_id = $request['post_id'];
                $like->category_post_id = $request['category_post_id'];
                $like->count = 1;
                $like->save();
                return response()->json(['action_status' => 'like created'], 200);
            } else
            { // Если оценивал
                if ($like->count == 1) { // Если оценил и уже был поставлен лайк
                    $like->count = 0;
                    $like->update();
                    return response()->json(['action_status' => 'like update - delete'.$user], 200);
                } else { // Если оценил и уже отменял свою оценку
                    $like->count = 1;
                    $like->update();
                    return response()->json(['action_status' => 'like update - create'.$user], 200);
                }
            }
        } else {
            return response()->json(['message' => 'user not auth', 'action_status' => 1], 200);
        }
    }
}
