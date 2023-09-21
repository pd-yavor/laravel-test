<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/purchase', [PageController::class, 'purchasePage'])->name('purchase');
Route::post('/api/purchase', [UserController::class, 'purchase'])->name('user.purchase');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
Route::get('/dashboard', [PageController::class, 'dashboardPage'])->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::post('/api/refund', [UserController::class, 'refundRequest'])->name('user.refund');

});
Route::group(['middleware' => ['role:Admin']],function () {
    Route::get('/users', [PageController::class, 'usersPage'])->middleware(['auth', 'verified'])->name('users');
    Route::post('/api/user/toggleAccess', [UserController::class, 'toggleAccess'])->name('user.toggleAccess');
});
require __DIR__.'/auth.php';
