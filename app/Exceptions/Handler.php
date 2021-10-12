<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
            //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception) {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception) {
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
                case '212':
                    return \Response::view('errors.212', array(), 212);
                    break;
                case '400':
                    return \Response::view('errors.400', array(), 403);
                    break;
                case '401':
                    return \Response::view('errors.401', array(), 401);
                    break;
                case '403':
                    return \Response::view('errors.403', array(), 403);
                    break;
                case '404':
                    return \Response::view('errors.404', array(), 404);
                    break;

                case '500':
                    return \Response::view('errors.500', array(), 500);
                    break;

                case '503':
                    return \Response::view('errors.503', array(), 503);
                    break;

                default:
                    return $this->renderHttpException($$exception);
                    break;
            }
        } else {

            if ($exception instanceof AuthorizationException) {
                return $this->unauthorized($request, $exception);
            }

            return parent::render($request, $exception);
        }
    }

    private function unauthorized($request, Exception $exception) {
        if ($request->expectsJson()) {
            return response()->json(['error' => $exception->getMessage()], 403);
        }

        flash()->warning($exception->getMessage());
        return redirect()->route('home');
    }

}



