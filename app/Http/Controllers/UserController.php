<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Articles;
use App\User;
use App\Comments;

use Auth;
use Image;


class UserController extends Controller
{
    public function profile() {
        $heading = 'Мой профиль';
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }
    public function update_avatar(Request $request) {
        // Handle the user upload of avatar
        $heading = 'Мой профиль';
        if ($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/uploads/avatars/'.$filename));

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
        }
        return view('profile', array('user' => Auth::user(), 'heading' => $heading));
    }
    public function profilePageArticles($user_name) {

        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

        $articles = Articles::where('user_id', '=', $user_id)->paginate(3);



        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page_articles', array(
                'heading' => $heading,
                'articles' => $articles,
                'user_exists' => 1,
                'user' => $user,
            ));
        } else {

            return view('profile_page_articles', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }
    public function profilePageComments($user_name) {

        $users = User::all();

        // get user id
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_id = $user->id;
        }

//        $articles = Articles::where('user_id', '=', $user_id)->paginate(3);

//        $comments = Comments::all()->sortByDesc('id');
        $comments = Comments::where('user_id', '=', $user_id)->paginate(3);
        $articles = Articles::all();
        $users = User::all();

        // Check if the user exists(существует)
        $user_exists = 0;
        foreach ($users as $user) {
            if ($user->name == $user_name)
                $user_exists = 1;
        }

        if ($user_exists == 1) {

            // получаем ид юзера из его имени
            foreach ($users as $user) {
                if ($user->name == $user_name)
                    $user_id = $user->id;
            }
            $user = User::find($user_id);

            $heading = 'Профиль пользователя: ' . $user_name;

            return view('profile_page_comments', array(
                'heading' => $heading,
                'articles' => $articles,
                'comments' => $comments,
                'user_exists' => 1,
                'user' => $user,
            ));
        } else {

            return view('profile_page_comments', array(
                'heading' => 'Пользователь ' . $user_name . ' не существует',
                'user_exists' => 0,
            ));
        }
    }

}
