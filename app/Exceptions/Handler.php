<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Exception $e,$request) {
            return $this->handleException($request, $e);
        });
    }

    
    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return $request->expectsJson()
                    ? response()->json([
                        'response_code' => 401,
                        'data' => [],
                        'message' => $exception->getMessage(),
                        'errors' => []
                        ], 401)
                    : redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function handleException($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            /* if ($exception->getStatusCode() == 404) {
                return response()->view('frontend.' . '404', [], 404);
            } */

            if ($exception->getStatusCode() == 403) {
                return redirect()->route('backend.dashboard')->with('error', 'You do not have the required authorization.');
            }
            /* if ($exception->getStatusCode() == 500) {
                return response()->view('frontend.' . '500', [], 500);
            }
            if ($exception->getStatusCode() == 419) {
                return redirect()->route('/');
            } */
        }


        // return response()->view('frontend.500', [], 500);

        // return parent::render($request, $exception);

    }
}
