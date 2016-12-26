<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

use App\Commands\StoreArticleCommand;
use App\Commands\UpdateArticleCommand;
use App\Commands\DestroyArticleCommand;
//use App\Commands\StoreArticleCommentCommand;
//use App\Commands\DestroyArticleCommentCommand;

use App\Articles;
use App\User;
//use App\ArticlesComments;
use App\Comments;

//use Carbon\Carbon;

//use Intervention\Image\Image as Image;
//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;

use Auth;

// Для редиректа на страницу профиля
use Illuminate\Support\Facades\Redirect;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $articles = Articles::all();
        $articles = Articles::orderBy('created_at', 'desc')->paginate(4);
        // $articles = Articles::orderBy('create_at', 'desc')->get(); сортировка, параметры: по какой колонке, как
        $users = User::all();
        $heading = 'Все статьи';

//        $comments = Comments::find();
        $comments = Comments::all();

//        $comments = Comments::with('category_item_id')->get()->find(32);

//        Article::with('category')->get()->find($ids);

//    print_r($comments);

        return view('articles', array(
            'articles' => $articles,
            'heading' => $heading,
            'users' => $users,
            'comments' => $comments,
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $heading = 'Добавить статью';
        return view('create_article', array('heading' => $heading));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        // validation
        $this->validate($request, [
            'title' => 'required|min:5',
//            'start_video' => 'date',
            'thumbnail' => 'mimes:jpeg,bmp,png,jpg|max:1024',
        ]);

        // Get Input
        $title = $request->input('title');
        $category = $request->input('category');
        $user_id = Auth::user()->id;
        $thumbnail = $request->file('thumbnail');
        $text = $request->input('text');
        $video_id = $request->input('video_id');
        $start_video = $request->input('start_video');
//        $tags = $request->input('tags');
        $tags = 'none';

//        print_r($thumbnail);

        // Check if image uploaded
//        if ($thumbnail) {

            $thumbnail_filename = $thumbnail->getClientOriginalName();

            $path_thumbnail = 'images/articles/'.$user_id;
            $path_thumbnail_original_file = $path_thumbnail . '/' . $thumbnail_filename;
            $path_thumbnail_resize_file = $path_thumbnail . '/thumb_' . $thumbnail_filename;

            $thumbnail->move(public_path($path_thumbnail), $thumbnail_filename);

            $img = Image::make($path_thumbnail_original_file);

            $width = 500;
            $height = 500;
            $img->width() > $img->height() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->fit(500);
            $img->save($path_thumbnail_resize_file);

//        } else {
//            $thumbnail_filename = 'noimage.jpg';
//        }

        // Create Command
        $command = new StoreArticleCommand($title, $category, $user_id, $thumbnail_filename, $text, $video_id, $start_video, $tags);

        // Run Command
        $this->dispatch($command);

        return \Redirect::route('articles.index')
            ->with('message', 'Статья успешно добалена');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = Articles::find($id);
//        $article_comment = ArticlesComments::where('article_id', '=', $id); хотел более правильно выборку сделать
        $article_comment = Comments::all()->sortByDesc('id');
        $users = User::all();
        $heading = 'Controller - Show article';

        return view('show_article', compact('article', 'article_comment', 'users', 'heading'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Articles::find($id);
        $heading = 'Редактировать статью';

        if(isset($_GET['red'])) { // если у ГЕТ есть праваметр red, то будем делать редирект
            if ($_GET['red'] == 'list') {
                $redirect = 'article_list';
            } if ($_GET['red'] == 'profile_page') {
                $redirect = 'profile_page';
            } elseif ($_GET['red'] == 'profile_articles') {
                $redirect = 'profile_articles';
            }
        } else { // иначе будем редеректить на страницу просмотра статьи
            $redirect = 'article_show';
        }

        return view('edit_article', compact('article', 'heading', 'redirect'));
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|min:5',
//            'start_video' => 'date',
            'thumbnail' => 'mimes:jpeg,bmp,png,jpg|max:1024',
        ]);
        
        // Get Input
        $title = $request->input('title');
        $category = $request->input('category');
//        $user_id = $request->input('user_id');
        $thumbnail = $request->file('thumbnail');
        $text = $request->input('text');
        $video_id = $request->input('video_id');
        $start_video = $request->input('start_video');
        $tags = $request->input('tags');
        $redirect = $request->input('redirect');

        $current_thumbnail_filename = Articles::find($id)->thumbnail;

// Check if image uploaded

        if ($thumbnail) {

            $thumbnail_filename = $thumbnail->getClientOriginalName();

            $user_id = Auth::user()->id;
            $path_thumbnail = 'images/articles/'.$user_id;
            $path_thumbnail_original_file = $path_thumbnail . '/' . $thumbnail_filename;
            $path_thumbnail_resize_file = $path_thumbnail . '/thumb_' . $thumbnail_filename;

            $thumbnail->move(public_path($path_thumbnail), $thumbnail_filename);

            $img = Image::make($path_thumbnail_original_file);

            $width = 500;
            $height = 500;
            $img->width() > $img->height() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->fit(500);
            $img->save($path_thumbnail_resize_file);

        } else {
            $thumbnail_filename = $current_thumbnail_filename;
        }

        // Update Command
        $command = new UpdateArticleCommand($id, $title, $category, $thumbnail_filename, $text, $video_id, $start_video, $tags);
        // Run Command
        $this->dispatch($command);

        if ($redirect == 'article_list') {
            return \Redirect::route('articles.index')
                ->with('message', 'Статья обновлена');
        } elseif ($redirect == 'profile_articles'){
//            $article = Articles::find($id);
//            $user = User::find($article->user_id);
//            $user_name = $user->name;
//            return Redirect::action('UserController@profilePage', $user_name);
            return Redirect::action('UserController@profilePageArticles', Auth::user()->name);
        } elseif ($redirect == 'profile_page'){
            return Redirect::action('UserController@profilePage', Auth::user()->name);
        } else {
            return redirect()->route('articles.show', $id)
                ->with('message', 'Статья обновлена');
        }

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $command = new DestroyArticleCommand($id);
        $this->dispatch($command);

        return \Redirect::route('articles.index')
            ->with('message', 'Статья удалена');
    }
    /**
     * Category page.
     */
    public function showCategory($category_name){
        $articles = Articles::where('category', '=', $category_name)->paginate(3);
        $users = User::all();
        $heading = 'Список статей категории - ' .  $category_name;
        $comments = Comments::all();

        return view('articles_category', array(
            'articles' => $articles,
            'heading' => $heading,
            'users' => $users,
            'category' => $category_name,
            'comments' => $comments

        ));

    }
    /**
     * My list articles.
     */
    public function showMyArticles()
    {
        $articles = Articles::all();
        $heading = 'Мои статьи';
        return view('my_articles', array('articles' => $articles, 'heading' => $heading));
    }
}
