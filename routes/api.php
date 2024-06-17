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


include_once __DIR__ . '/api/auth.php';
include_once __DIR__ . '/api/mail.php';
include_once __DIR__ . '/api/password.php';


Route::apiResource('users', \App\Http\Controllers\UserController::class);
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class);
Route::apiResource('items', \App\Http\Controllers\ItemController::class);
Route::apiResource('types', \App\Http\Controllers\TypeController::class);
//Route::apiResource('groups', \App\Http\Controllers\GroupController::class);
Route::apiResource('room_types', \App\Http\Controllers\RoomTypeController::class);
Route::apiResource('rooms', \App\Http\Controllers\RoomController::class);
Route::apiResource('confirmations', \App\Http\Controllers\ConfirmationController::class);
//Route::apiResource('customers', \App\Http\Controllers\CustomerController::class);
Route::apiResource('suppliers', \App\Http\Controllers\SupplierController::class);
Route::apiResource('checkins', \App\Http\Controllers\CheckinController::class);
Route::apiResource('checkouts', \App\Http\Controllers\CheckoutController::class);
Route::apiResource('transfers', \App\Http\Controllers\TransferController::class);
Route::apiResource('roles', \App\Http\Controllers\RoleController::class);
Route::apiResource('responsibilities', \App\Http\Controllers\ResponsibilityController::class);

Route::apiResource('permissions', \App\Http\Controllers\PermissionController::class)->only(['index', 'show']);
Route::apiResource('activities', \App\Http\Controllers\ActivityController::class)->only(['index', 'show']);

Route::apiResource('invite_codes', \App\Http\Controllers\InviteCodeController::class)->only(['index', 'show', 'destroy']);

Route::apiResource('transfer_statuses', \App\Http\Controllers\TransferStatusController::class)->only(['index']);

Route::post('transfers/{transfer}/change_status', [\App\Http\Controllers\TransferController::class, 'changeStatus']);
Route::post('change_email', [\App\Http\Controllers\UserController::class, 'changeEmail']);

Route::apiResource('racks', \App\Http\Controllers\RackController::class)->only('index', 'show');



// отчетная документация:
//    сколько выдано товаров
//    скольво выданно конкретному лицу

// поступления
// стелажи для помещений
// добавление товра для выдачи
// добавить типы для помещений (склад / кабинет)

// добавить поставщиков
// внешних покупателей нет
// списаниех
// штучное списание
// при перемещении создавать новый item с пользовательским кодом

/*
 * add room_type for rooms
 * delete customers
 * */


/*

Админ
Управление пользователеми
Управление ваучерами (пригласительный код)
Управление помещениями
Управление поставщиками
Подтверждение переноса товара
...все остальное

Кладовщик
Управление котегориями и типами товаров
Поступление товаров
Выгрузка товаров
Перемещение между помещениями (скаладами, стелажами)
Присвоение объекта ответвенным лицам (перемещение между помещениям, какое в кабинете)
Инвентаризации

Пользователь (Ответственное лицо)
Просмотр помещения
Просмотр товаров
Запрос на перемещение товара
*/


/*

Функционал для бота:

Администратор:
Получение перемещений
GET transfers

Подтверждение перемещения
POST transfers/{transfer_id}/change_status
    'transfer_status_id' => 'required|exists:transfer_statuses,id',

Кладовщик:
Инвентарицация
POST confirmations
     'item_id' => 'required|exists:items,id',
     'quantity' => 'numeric',


Пользователь:
Запрос на перемещение товаров
POST transfers
            'reason' => 'nullable|string',
            'from_room_id' => 'required|integer|exists:rooms,id',
            'to_room_id' => 'required|integer|exists:rooms,id',

            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:items,id',
            'items.*.room_id' => 'required|integer|exists:rooms,id',
            'items.*.quantity' => 'nullable|numeric',

Все:
Поиск товара по баркоду
GET items
            'code' => 'nullable|string',

Получение информации товара
GET items/{id}



Бизнесс таблицы:
  users
  categories
  types
  rooms
  confirmations
  suppliers
  items
  checkins
  checkouts
  checkin_item
  checkout_item
  transfers
  item_transfer
  room_types
  invite_codes
  transfer_statuses
  racks

*/





