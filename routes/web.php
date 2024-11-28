<?php

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
	'middleware' => ['auth','role:superadmin'],
],function(){

    Route::get('/password/update',[DashboardController::class, 'updatePassword'])->name('password.update');
    Route::post('/password/update',[DashboardController::class, 'updatePassword'])->name('password.update');

    Route::group([
        'middleware' => ['role_or_permission:superadmin|View Data'],
    ],function(){

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Route::get('/{slug}',[\App\Http\Controllers\FrontPageController::class, 'backendPages'])->name('backend-pages');
    Route::get("/orders", [OrdersController::class,"index"])->name("orders");
    Route::get('/orders/view/{order_uuid}', [OrdersController::class,'view_order'])->name('order.view');
    Route::get("/orders/live-tracking", [OrdersController::class,"live_tracking"])->name("orders.liveTracking");
});

require __DIR__.'/auth.php';

