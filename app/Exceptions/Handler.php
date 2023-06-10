<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
//        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
//            return response()->json([
//                'message' => 'You do not have the required authorization.',
//            ], 403);
//        });
//
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => 'Not found',
            ], 404);
        });

        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
