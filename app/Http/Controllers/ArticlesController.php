<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

use App\Commands\StoreArticleCommand;
use App\Commands\UpdateArticleCommand;
use App\Commands\DestroyArticleCommand;

use App\Articles;
use App\User;
//use App\ArticlesComments;
use App\Comments;

//use Carbon\Carbon;

//use Intervention\Image\Image as Image;
//use Intervention\Image\Image;
use Intervention\Image\Facades\Image;

use File;

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
//        $articles = Articles::orderBy('created_at', 'desc')->paginate(2);
        $articles = Articles::where('user_id', '>', -1)->where('publish', '=', 1)->orderBy('id', 'desc')->paginate(2);

        $users = User::all();
        $heading = 'Все статьи';
        $comments = Comments::all();

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
            'title' => 'required|min:2',
//            'start_video' => 'date',
            'thumbnail' => 'mimes:jpeg,bmp,png,jpg|max:2024',
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

        if (isset($article)) {
//        $article_comment = ArticlesComments::where('article_id', '=', $id); хотел более правильно выборку сделать
            $article_comment = Comments::all()->sortByDesc('id');
            $users = User::all();
            $heading = 'Controller - Show article';

            // Счетчики комментариев и статей для сайтбара
            $articles_count = Articles::where('user_id', '=', $article->user_id)->where('publish', '=', 1)->count();
            $comments_count = Comments::where('user_id', '=', $article->user_id)->where('publish', '=', 1)->count();

            return view('show_article', compact('article', 'article_comment', 'users', 'heading', 'articles_count', 'comments_count'));
        }
        abort(404, 'show article');
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

        $article = Articles::find($id);

        if (isset($article)) {
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
        abort(404, 'edit article');
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
            'title' => 'required',
//            'start_video' => 'date',
            'thumbnail' => 'mimes:jpeg,bmp,png,jpg|max:2024',
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

        // если миниатюра существует, а она всегда существует, проверку можно удалить
        if ($thumbnail) {

            $user_id = Auth::user()->id;                                            // получаем id залогиненого пользователя
            $article = Articles::find($id);                                                  // Получаем массив статьи


            $thumbnail_original_filename = $thumbnail->getClientOriginalName();           // Получим имя картинки из объекта загружанного через форму, это нужно было для того чтобы оставить оригинальное название файла
            $ext_info = pathinfo($thumbnail_original_filename);                        // получаем масив данных файла(имя, разшерение..)
            $file_extension = ".".$ext_info['extension'];                           // получаем расшерение файла

            $thumbnail_filename = 'art-thumbnail-u'.$user_id.'a'.$id.'e'.time().$file_extension;  // создаем уникальное имя файла
            $path_thumbnail = 'uploads/articles/'.$id;                                      // создаем путь к папке, где хранятся аватарки
            $path_thumbnail_file = $path_thumbnail .'/'. $thumbnail_filename;                    // Создаем путь для оптимизированного файла

//            print_r($file_extension);
//            echo '<br>';
//            print_r($thumbnail_filename);

            $thumbnail->move(public_path($path_thumbnail), $thumbnail_filename);             // берет картинку из формы и делает копию на сервере
            $img = Image::make($path_thumbnail_file);                                  // Добавляет объект от оригинальной фотографии, для обработки

            // Обрезаем по меньшей стороне
            $width = 500;
            $height = 500;
            $img->width() > $img->height() ? $width=null : $height=null;            // Большая сторона будет обрезатся
            $img->resize($width, $height, function ($constraint) {                  // Обрезаем более широкую или узкую сторону
                $constraint->aspectRatio();                                         // образаем пропорционально от центра
            });
            $img->fit(500);                                                         // Обрезаем по меньшей стороне
            $img->save($path_thumbnail_file);                                          // сохраняем оптимизированную картинку, ПЕРЕЗАПИСЫВАЯ оригинальную картинку

            $old_thumbnail_filename = $article->thumbnail;                                   // Название предыдущего файла картинки
            if ($thumbnail != 'no_article.jpg') {                          // Если название не менялось, стоит картинка по умолчанию, то ее трогать не будем
                $old_path_thumbnail_file = $path_thumbnail . '/' . $old_thumbnail_filename;  // путь к старому файлу
                File::delete($old_path_thumbnail_file);                                // удаляем старый файл
            }
        }


        // Update Command
        $command = new UpdateArticleCommand($id, $title, $category, $thumbnail_filename, $text, $video_id, $start_video, $tags);
        // Run Command
        $this->dispatch($command);

        if ($redirect == 'article_list') {
            return \Redirect::route('articles.index')
                ->with('message', 'Статья обновлена');
        } elseif ($redirect == 'profile_articles'){
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

        // Admin check
        $auth_user_id = Auth::user()->id;
        if ($auth_user_id == 1) {
            $this->dispatch($command);
            return back()->with('message', 'Статья удалена из базы данных(с правами администратора)');
        } else {
            // Записываю в лог попытку хака
            DB::table('hacking_attempt')->insert([
//                'place' => 'удаление статьи из бд '.$uri,
                'object' => 'статья номер: '.$id,
                'who' => 'попытался пользователь: '.$auth_user_id,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            return back()->with('message', 'Вы не можите удалить статью, у вас нет прав');
        }
    }

    /**
     * Category articles page.
     */
    public function showCategory($category_name)
    {
        if ($category_name == 'News' or $category_name == 'None') {
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
        abort(404, 'show category article');
    }

    /**
     * Admin page with all articles and tools
     */
    public function adminTableArticles()
    {
        $articles = Articles::where('user_id', '>', -1)->orderBy('id', 'desc')->paginate(10);
        $articles_count = Articles::all()->count();
        $amount_pages = ceil($articles_count / 10);
        $heading = 'Админ: все статьи';

        return view('admin_table_articles', array(
            'articles' => $articles,
            'heading' => $heading,
            'amount_pages' => $amount_pages,
        ));
    }

    /**
     * Сделать статью неопубликованной
     */
    public function delete(Request $request, $id)
    {

        $article = Articles::find($id);
        $article->publish = 0;

        // Проверка является ли статья того пользователя, который пытается ее удалить
        $user_id = $article->user_id;
        $auth_user_id = Auth::user()->id;
        $auth_user_role = Auth::user()->role;
        $uri = $request->path();

        if ($user_id == $auth_user_id) {
            $article->save();
            return back()->with('message', 'Статья удалена');
        } else {
            // Админу можно
            if ($auth_user_role == 1) {
                $article->save();
                return back()->with('message', 'Вы убрали статью из публикации, используя права администратора');
            } else {
                // Записываю в лог попытку хака
                if (!$auth_user_id)
                    $auth_user_id = 'не авторизированный';
                DB::table('hacking_attempt')->insert([
                    'place' => 'удаление статьи '.$uri,
                    'object' => 'Номер статьи: '.$id,
                    'who' => 'попытался пользователь: '.$auth_user_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
                return back()->with('message', 'У вас нет прав для удаления этой статьи');
            }
        }
    }

    /**
     * Сделать статью опять опубликованной
     */
    public function unDelete(Request $request, $id)
    {

        $article = Articles::find($id);
        $article->publish = 1;

        // Проверка является ли сообщение того пользователя, который пытается его удалить
        $user_id = $article->user_id;
        $auth_user_id = Auth::user()->id;
        $auth_user_role = Auth::user()->role;
        $uri = $request->path();

        if ($user_id == $auth_user_id) {
            $article->save();
            return back()->with('message', 'Статья '.$id.' опубликованна');
        } else {
            // Админу можно
            if ($auth_user_role == 1) {
                $article->save();
                return back()->with('message', 'Вы сделали статью опубликованной, используя права администратора');

            } else {
                // Записываю в лог попытку хака
                if (!$auth_user_id)
                    $auth_user_id = 'не авторизированный';
                DB::table('hacking_attempt')->insert([
                    'place' => 'сделать статью опубликованной '.$uri,
                    'object' => 'Номер статьи: '.$id,
                    'who' => 'попытался пользователь: '.$auth_user_id,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s"),
                ]);
                return back()->with('message', 'У вас нет прав для публикации этой статьи');
            }
        }
    }
}
