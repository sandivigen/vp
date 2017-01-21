<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        // Custom render
        if ($this->isHttpException($e)) { // если получаем http ошибку

            $statusCode = $e->getStatusCode(); // получаем номер ошибки

//            dd($e->getMessage());

            if ($e->getMessage() == "show article")
            {
                $data_error = [
                    'message' => 'Данной статьи не существует',
                    'recommended' => 'show article',
                    'heading' => 'Статья не найдена',
                ];
                Log::alert('Страница статьи не найдена - '.$request->url());
            }

            elseif ($e->getMessage() == "edit article")
            {
                $data_error = [
                    'message' => 'Страница которую вы хотите редактировать не существует. Проверте адресс ссылки.',
                    'recommended' => 'show 404',
                    'heading' => 'Статья не найдена',
                ];
                Log::alert('Страница редактирования статьи не найдена - '.$request->url());
            }

            elseif ($e->getMessage() == "show category article")
            {
                $data_error = [
                    'message' => 'Данной категории статей не существует, проверте ваш запрос',
                    'recommended' => 'show 404',
                    'heading' => 'Категория не найдена',
                ];
                Log::alert('Страница категории статьи не найдена - '.$request->url());
            }

            elseif ($e->getMessage() == "show user profile")
            {
                $data_error = [
                    'message' => 'Данного пользователя не существует',
                    'recommended' => 'show 404',
                    'heading' => 'Пользователь не найден',
                ];
                Log::alert('Страница профиля пользователя не найдена - '.$request->url());
            }

            elseif ($e->getMessage() == "404")
            {
                $data_error = [
                    'message' => 'Запрашиваемой страницы не существует',
                    'recommended' => 'show 404',
                    'heading' => 'Страница не найдена',
                ];
                Log::alert('Страница(пользовательская 404) статьи не найдена - '.$request->url());
            }

            else
            {
                $data_error = [
                    'message' => '404 - страницы не существует',
                    'recommended' => 'show 404',
                    'heading' => 'Страница не найдена',
                ];
                Log::alert('Страница(стандартная) статьи не найдена - '.$request->url());
            }

            switch ($statusCode) {
                case '404' :
                    return response()->view('404', $data_error);
            }
        }

        return parent::render($request, $e);
    }
}
