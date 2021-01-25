<?php

namespace App\Exceptions;

use App\Traits\Http\APIResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;

class Handler extends ExceptionHandler {

    use APIResponse;
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
    public function register() {
        $this->reportable(function (Throwable $e) {
            Log::info($e);
        });
    }

    public function report(Throwable $exception) {
        parent::report($exception);
        //return $this->handlerException($exception);
    }

    public function render($request, Throwable $exception) {
        return $this->handlerException($exception);
        //return parent::render($request, $exception);
    }
}
