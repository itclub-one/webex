<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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

//     public function render($request, Throwable $exception)
// {
//     if ($exception instanceof ModelNotFoundException) {
//         if (str_contains($request->url(), '/admin')) {
//             return response()->view('errors.minimal', [
//                 'code' => 404,
//                 'title' => 'Not Found',
//                 'message' => 'Halaman tidak ditemukan, pastikan URL Anda dengan benar'
//             ], 404);
//         } else {
//             return response()->view('errors.frontpage', [
//                 'code' => 404,
//                 'title' => 'Not Found',
//                 'message' => 'Halaman tidak ditemukan, pastikan URL Anda dengan benar'
//             ], 404);
//         }
//     }

//     if ($this->isHttpException($exception)) {
//         if (str_contains($request->url(), '/admin')) {
//             return response()->view('errors.minimal', [
//                 'code' => 500,
//                 'title' => 'Server Error',
//                 'message' => 'Hubungi Developer WEBEX'
//             ], 500);
//         } else {
//             return response()->view('errors.frontpage', [
//                 'code' => 500,
//                 'title' => 'Server Error',
//                 'message' => 'Hubungi Developer WEBEX'
//             ], 500);
//         }
//     }

//     return parent::render($request, $exception);
// }

}
