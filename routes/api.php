<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Cat;
use App\Http\Controllers\Contact;
use App\Http\Controllers\Order;
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

Route::get('/cats', Cat\GetAvailableCatsController::class);
Route::get('/parents', Cat\GetPedigreeController::class);
Route::get('/cats/{id}', Cat\GetOneCatController::class);

Route::get('/contacts', Contact\GetContactController::class);

Route::post('/orders', Order\CreateOrderController::class);

Route::prefix('admin')->group(function () {
    Route::post('/login', Admin\Auth\LoginController::class);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/logout', Admin\Auth\LogoutController::class);
        Route::post('/cats', Admin\Cat\CreateCatController::class);
        Route::get('/cats', Admin\Cat\GetCatsController::class);
        Route::patch('/cats/{id}', Admin\Cat\UpdateCatController::class);
        Route::delete('/cats/{id}', Admin\Cat\DeleteCatController::class);

        Route::patch('/contacts', Admin\Contact\UpdateContactController::class);

        Route::get('/orders', Admin\Order\GetOrdersController::class);
        Route::post('/orders/{id}/approve', Admin\Order\ApproveOrderController::class);
        Route::post('/orders/{id}/decline', Admin\Order\DeclineOrderController::class);
    });
});



