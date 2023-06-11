<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


include_once __DIR__ . '/auth.php';

Route::apiResources([
    'users' => \App\Http\Controllers\UserController::class,
    'categories' => \App\Http\Controllers\CategoryController::class,
    'items' => \App\Http\Controllers\ItemController::class,
    'types' => \App\Http\Controllers\TypeController::class,
    'groups' => \App\Http\Controllers\GroupController::class,
    'rooms' => \App\Http\Controllers\RoomController::class,
    'confirmations' => \App\Http\Controllers\ConfirmationController::class,
    'customers' => \App\Http\Controllers\CustomerController::class,
    'suppliers' => \App\Http\Controllers\SupplierController::class,
]);
