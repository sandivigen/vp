<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
        if ($this->isHttpException($e)) {
            $statusCode = $e->getStatusCode();

//            dd($e->getMessage());

            if ($e->getMessage() == "show article") {
                $data_error = [
                    'message' => 'Данной статьи не сущечтвует',
                    'recommended' => 'show article',
                ];
            } else {
                $data_error = [
                    'message' => 'Данной страницы не сущечтвует',
                    'recommended' => 'show 404',
                ];
            }

            switch ($statusCode) {
                case '404' :
                    return response()->view('404', $data_error);
            }
        }

        return parent::render($request, $e);
    }
}
