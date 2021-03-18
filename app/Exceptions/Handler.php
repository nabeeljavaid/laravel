<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        // Exception Handling for API Routes
        if($request->is('api/*') or $request->expectsJson()) {
            if ($exception instanceof ModelNotFoundException)
            {
                return response()->json([
                    'message' => 'Sorry, No Record Found'
                ], Response::HTTP_NOT_FOUND);
            } elseif($exception instanceof ValidationException) {
                // Do Nothing
            } else {
                return response()->json([
                    'message' => 'Oops, something went wrong',
                ]);
            }
        }
        
        return parent::render($request, $exception);
    }   
}
