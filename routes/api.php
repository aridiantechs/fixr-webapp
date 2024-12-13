<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Orders\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    "prefix" => "auth"
], function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
});
Route::group([
    "prefix" => "orders", // the url will be of the form -> fixr.com/api/orders/{route}
    "middleware" => ["api", "auth:sanctum"]
], function () {
    Route::post("/store", [OrdersController::class, 'store']);
});
Route::group([
    'middleware' => ['api', 'auth:sanctum']
], function () {
    Route::get('/card-proxy-data', [OrdersController::class, "get_card_proxy_data"]);
    Route::get('/task-data', [OrdersController::class,'get_task_data']);
});

Route::get('/automation-data', [OrdersController::class,'get_automation_data']);