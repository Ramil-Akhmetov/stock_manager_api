<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth API Routes
|--------------------------------------------------------------------------
*/

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\AuthController::class, 'user']);

    Route::post('/reset_password', [\App\Http\Controllers\PasswordController::class, 'reset_password']);
});

Route::post('/forgot_password', [\App\Http\Controllers\PasswordController::class, 'forgot_password']);
Route::post('/reset_forgot_password', [\App\Http\Controllers\PasswordController::class, 'reset_forgot_password']);


// Verify email
Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Http\Request $request) {
    $user_id = $request->route('id');
    $user = \App\Models\User::find($user_id);

    if ($user->hasVerifiedEmail()) {
        return redirect(env('FRONT_URL') . '/login');
    }

    if ($user->markEmailAsVerified()) {
        event(new \Illuminate\Auth\Events\Verified($user));
    }

    return redirect(env('FRONT_URL') . '/login');
})
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Resend link to verify email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');
