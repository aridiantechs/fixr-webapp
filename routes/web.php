<?php

use App\Http\Controllers\Admin\AutomationController;
use App\Http\Controllers\Admin\PaymentCardController;
use App\Http\Controllers\Admin\ProxyController;
use App\Http\Controllers\Admin\TasksController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//test notification
// Route::get('test_notification',[App\Http\Controllers\App\DataController::class, 'testNotify']);

Route::get('lang/{locale}', [\App\Http\Controllers\LocalizationController::class, 'index'])->name('lang_change');
Route::get('/', function () {
    return redirect()->route('login');
})->name('/');


Route::group([
    'prefix' => 'backend',
    'as' => 'backend.',
    'middleware' => ['auth', 'role:superadmin'],
], function () {

    Route::get('/password/update', [DashboardController::class, 'updatePassword'])->name('password.update');
    Route::post('/password/update', [DashboardController::class, 'updatePassword'])->name('password.update');

    Route::group([
        'middleware' => ['role_or_permission:superadmin|View Data'],
    ], function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Route::get('/{slug}',[\App\Http\Controllers\FrontPageController::class, 'backendPages'])->name('backend-pages');
    Route::get("/orders", [OrdersController::class, "index"])->name("orders");
    Route::get('/orders/view/{order_uuid}', [OrdersController::class, 'view_order'])->name('order.view');
    Route::get("/orders/live-tracking", [OrdersController::class, "live_tracking"])->name("orders.liveTracking");

    //tasks routes
    Route::group([
        "prefix" => "tasks",
        "as" => "tasks."
    ], function () {
        Route::get("/", [TasksController::class, "index"])->name("view");
        Route::get("/create", [TasksController::class, "show_create_form"])->name("create.view");
        Route::post("/store", [TasksController::class, "store"])->name("store");
        Route::get("/update/{task}", [TasksController::class, "show_update_form"])->name("update.view");
        Route::post("/update/{task_id}", [TasksController::class, "update"])->name("update");
        Route::get("/delete/{task_id}", [TasksController::class, "delete"])->name("delete");
    });

    //proxies routes
    Route::group([
        "prefix" => "proxies",
        "as" => "proxy."
    ], function () {
        Route::get("/", [ProxyController::class, "index"])->name("view");
        Route::post("/store", [ProxyController::class, "store"])->name("store");
        Route::get("/update/{proxy}", [ProxyController::class, "show_update_form"])->name("update.view");
        Route::post("/update/{proxy_id}", [ProxyController::class, "update"])->name("update");
        Route::get("/delete/{proxy_id}", [ProxyController::class, "delete"])->name("delete");
    });

    //automation control routes
    Route::group([
        "prefix" => "settings",
        "as" => "setting."
    ], function () {
        Route::get("/", [AutomationController::class, "index"])->name("view");
        Route::post("/store/automation", [AutomationController::class, "store"])->name("store.automation");
        Route::post("/store", [AutomationController::class, "store_setting"])->name("store.setting");
    });

    //payment cards routes
    Route::group([
        "prefix" => "payment_cards",
        "as" => "payment_card."
    ], function () {
        Route::get("/", [PaymentCardController::class, "index"])->name("view");
        Route::get("/create", [PaymentCardController::class, "show_create_form"])->name("create.view");
        Route::post("/store", [PaymentCardController::class, "store"])->name("store");
        Route::get("/update/{payment_card}", [PaymentCardController::class, "show_update_form"])->name("update.view");
        Route::post("/update/{payment_card_id}", [PaymentCardController::class, "update"])->name("update");
        Route::get("/delete/{payment_card_id}", [PaymentCardController::class, "delete"])->name("delete");
    });



});

require __DIR__ . '/auth.php';

