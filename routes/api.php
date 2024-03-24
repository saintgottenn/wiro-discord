<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BankLogController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\ProductLogController;
use App\Http\Controllers\SellerStatController;
use App\Http\Controllers\TicketChatController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\ProductReturnController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('sanctum-guest')->group(function() {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');    
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user/settings', [UserSettingsController::class, 'index']);
    Route::put('/user/settings', [UserSettingsController::class, 'update']);

    Route::get('/tickets/', [TicketController::class, 'index']);
    Route::get('/tickets/hot', [TicketController::class, 'hot']);
    Route::post('/tickets/', [TicketController::class, 'store']);
    Route::get('/tickets/{id}', [TicketController::class, 'show']);
    Route::post('/tickets/{id}/close', [TicketController::class, 'close']);
    Route::post('/tickets/{id}/send-message', [TicketChatController::class, 'sendMessage']);

    Route::get('/returns/', [ProductReturnController::class, 'index']);
    Route::post('/returns/', [ProductReturnController::class, 'store']);
    Route::get('/returns/{id}/', [ProductReturnController::class, 'show']);
    Route::post('/returns/{id}/refund', [ProductReturnController::class, 'refund']);
    Route::post('/returns/{id}/close', [ProductReturnController::class, 'close']);

    Route::get('/offers/', [ProductLogController::class, 'index']);
    Route::get('/offers/hot', [ProductLogController::class, 'hotOffers']);
    
    // sellers
    Route::post('/offers/', [ProductLogController::class, 'store']);
    Route::post('/offers/{id}/update', [ProductLogController::class, 'update']);
    Route::delete('/offers/{id}/delete', [ProductLogController::class, 'delete']);

    Route::get('/banks/', [BankLogController::class, 'index']);
    Route::post('/banks/', [BankLogController::class, 'store']);
    Route::post('/banks/{id}/update', [BankLogController::class, 'update']);
    Route::delete('/banks/{id}/delete', [BankLogController::class, 'delete']);

    Route::get('/transactions', [TransactionController::class, 'allTransactions']);

    Route::get('/cart/', [CartController::class, 'getProducts']);
    Route::post('/cart/buy', [CartController::class, 'buy']);

    Route::post('/withdrawals', [WithdrawalController::class, 'store']);
    
    Route::get('/user/stats', [SellerStatController::class, 'stats']);
    
    Route::get('/download/', [DownloadController::class, 'download']);
    
    Route::get('/payment/processes', [PaymentController::class, 'allProcesses']);
    Route::post('/payment/{currency}', [PaymentController::class, 'process']);
    Route::get('/exchange/{currency}', [PaymentController::class, 'getExchangeRates']);
}); 
